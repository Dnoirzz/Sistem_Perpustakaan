<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Petugas;
use App\Models\ActivityLog;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $roleId = $request->input('role_id');

        $users = User::with(['role', 'mahasiswa.prodi', 'dosen.prodi', 'petugas'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhereHas('mahasiswa', function ($m) use ($search) {
                          $m->where('nim', 'like', "%{$search}%");
                      })
                      ->orWhereHas('dosen', function ($d) use ($search) {
                          $d->where('nip', 'like', "%{$search}%");
                      })
                      ->orWhereHas('petugas', function ($p) use ($search) {
                          $p->where('nip', 'like', "%{$search}%");
                      });
                });
            })
            ->when($roleId, function ($query, $roleId) {
                return $query->where('role_id', $roleId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles', 'search', 'roleId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $prodis = Prodi::orderBy('nama_prodi')->get();
        return view('admin.users.create', compact('roles', 'prodis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'no_hp' => ['required', 'digits_between:1,20'],
            'role_id' => ['required', 'exists:roles,role_id'],
        ];

        $role = Role::find($request->role_id);

        if ($role) {
            if ($role->role_name === 'mahasiswa') {
                $rules['nim'] = ['required', 'digits:10', 'unique:mahasiswas,nim'];
                $rules['prodi_id'] = ['required', 'exists:prodi,prodi_id'];
                $rules['semester'] = ['required', 'string', 'max:10'];
            } elseif ($role->role_name === 'dosen') {
                $rules['nip'] = ['required', 'digits:18', 'unique:dosens,nip'];
                $rules['prodi_id'] = ['required', 'exists:prodi,prodi_id'];
            } elseif ($role->role_name === 'petugas') {
                $rules['nip'] = ['required', 'digits:18', 'unique:petugas,nip'];
                $rules['jabatan'] = ['nullable', 'string', 'max:100'];
            }
        }

        $request->validate($rules);

        DB::transaction(function () use ($request, $role) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_hp' => $request->no_hp,
                'role_id' => $request->role_id,
            ]);

            if ($role->role_name === 'mahasiswa') {
                Mahasiswa::create([
                    'user_id' => $user->user_id,
                    'prodi_id' => $request->prodi_id,
                    'nim' => $request->nim,
                    'semester' => $request->semester,
                ]);
            } elseif ($role->role_name === 'dosen') {
                Dosen::create([
                    'user_id' => $user->user_id,
                    'nip' => $request->nip,
                    'prodi_id' => $request->prodi_id,
                ]);
            } elseif ($role->role_name === 'petugas') {
                Petugas::create([
                    'user_id' => $user->user_id,
                    'nip' => $request->nip,
                    'jabatan' => $request->jabatan,
                ]);
            }
        });

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->load(['role', 'mahasiswa', 'dosen', 'petugas']);
        $roles = Role::all();
        $prodis = Prodi::orderBy('nama_prodi')->get();
        return view('admin.users.edit', compact('user', 'roles', 'prodis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->user_id, 'user_id')],
            'no_hp' => ['required', 'digits_between:1,20'],
            'role_id' => ['required', 'exists:roles,role_id'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $newRole = Role::find($request->role_id);
        $oldRole = $user->role;

        if ($newRole) {
            if ($newRole->role_name === 'mahasiswa') {
                $mhsId = $user->mahasiswa->mhs_id ?? 0;
                $rules['nim'] = ['required', 'digits:10', Rule::unique('mahasiswas', 'nim')->ignore($mhsId, 'mhs_id')];
                $rules['prodi_id'] = ['required', 'exists:prodi,prodi_id'];
                $rules['semester'] = ['required', 'string', 'max:10'];
            } elseif ($newRole->role_name === 'dosen') {
                $dosenId = $user->dosen->dosen_id ?? 0;
                $rules['nip'] = ['required', 'digits:18', Rule::unique('dosens', 'nip')->ignore($dosenId, 'dosen_id')];
                $rules['prodi_id'] = ['required', 'exists:prodi,prodi_id'];
            } elseif ($newRole->role_name === 'petugas') {
                $staffId = $user->petugas->staff_id ?? 0;
                $rules['nip'] = ['required', 'digits:18', Rule::unique('petugas', 'nip')->ignore($staffId, 'staff_id')];
                $rules['jabatan'] = ['nullable', 'string', 'max:100'];
            }
        }

        $request->validate($rules);

        DB::transaction(function () use ($request, $user, $newRole, $oldRole) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'role_id' => $request->role_id,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // If role has changed, delete old profile
            if ($oldRole->role_id != $newRole->role_id) {
                if ($oldRole->role_name === 'mahasiswa') {
                    Mahasiswa::where('user_id', $user->user_id)->delete();
                } elseif ($oldRole->role_name === 'dosen') {
                    Dosen::where('user_id', $user->user_id)->delete();
                } elseif ($oldRole->role_name === 'petugas') {
                    Petugas::where('user_id', $user->user_id)->delete();
                }
            }

            // Create/Update the current role profile
            if ($newRole->role_name === 'mahasiswa') {
                Mahasiswa::updateOrCreate(
                    ['user_id' => $user->user_id],
                    [
                        'prodi_id' => $request->prodi_id,
                        'nim' => $request->nim,
                        'semester' => $request->semester,
                    ]
                );
            } elseif ($newRole->role_name === 'dosen') {
                Dosen::updateOrCreate(
                    ['user_id' => $user->user_id],
                    [
                        'nip' => $request->nip,
                        'prodi_id' => $request->prodi_id,
                    ]
                );
            } elseif ($newRole->role_name === 'petugas') {
                Petugas::updateOrCreate(
                    ['user_id' => $user->user_id],
                    [
                        'nip' => $request->nip,
                        'jabatan' => $request->jabatan,
                    ]
                );
            }
        });

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Show the user import form.
     */
    public function showImportForm()
    {
        return view('admin.users.import');
    }

    /**
     * Download the import excel template.
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Import');

        // Panduan Pengisian di bagian atas
        $sheet->setCellValue('A1', 'PANDUAN IMPORT USER/ANGGOTA SIPUS');
        $sheet->setCellValue('A2', '1. Kolom "Nama Lengkap", "NIM / NIP", "Jurusan", dan "Program Studi" wajib diisi.');
        $sheet->setCellValue('A3', '2. Kolom "Semester" diisi jika tipe user adalah MAHASISWA (misal: "Semester 1", "3", "6").');
        $sheet->setCellValue('A4', '3. Kosongkan kolom "Semester" jika tipe user adalah DOSEN.');
        $sheet->setCellValue('A5', '4. Nama Program Studi harus sama persis dengan yang terdaftar di sistem (case-insensitive).');
        $sheet->setCellValue('A6', '5. Sistem otomatis membuat Akun: Email = [NIM/NIP]@sipus.polnep.ac.id | Password = sipus[NIM/NIP].');
        
        // Merge cells for header instruction
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);

        // Header Tabel di baris 8
        $headers = ['Nama Lengkap', 'NIM / NIP', 'Jurusan', 'Program Studi', 'Semester'];
        $sheet->fromArray($headers, null, 'A8');

        // Style header tabel
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '00A5C0'], // POLNEP Turquoise brand color
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];
        $sheet->getStyle('A8:E8')->applyFromArray($headerStyle);

        // Contoh Data (Baris 9 dan 10)
        $examples = [
            ['Rian Yulianto', '3202316109', 'Teknik Elektro', 'D3 Teknik Informatika', 'Semester 6'],
            ['Dr. Eng. H. Muhammad, M.T.', '198005122005011002', 'Teknik Elektro', 'D3 Teknik Informatika', '']
        ];
        $sheet->fromArray($examples, null, 'A9');

        // Auto size columns
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        
        $filename = 'template_import_user_sipus.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    /**
     * Import users from uploaded excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'], // Max 10MB
        ]);

        $file = $request->file('file');
        
        try {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Gagal membaca berkas Excel: ' . $e->getMessage()]);
        }

        // Cari tahu index mulai data. 
        // Baris 1-7 adalah panduan, baris 8 adalah header, baris 9 dst adalah data.
        $startIndex = 8; 
        $totalRows = count($rows);

        if ($totalRows <= $startIndex) {
            return back()->withErrors(['file' => 'Berkas Excel tidak memiliki data untuk di-import.']);
        }

        $errors = [];
        $importedCount = 0;
        $skippedCount = 0;

        // Ambil data Program Studi untuk validasi cepat
        $prodis = Prodi::all();
        $roleMahasiswa = Role::where('role_name', 'mahasiswa')->first();
        $roleDosen = Role::where('role_name', 'dosen')->first();

        if (!$roleMahasiswa || !$roleDosen) {
            return back()->withErrors(['file' => 'Peran (Role) mahasiswa atau dosen tidak ditemukan di sistem.']);
        }

        // Tahap 1: Validasi format data di seluruh baris
        for ($i = $startIndex; $i < $totalRows; $i++) {
            $row = $rows[$i];
            
            // Bersihkan data spasi
            $name = isset($row[0]) ? trim($row[0]) : '';
            $nimNip = isset($row[1]) ? trim($row[1]) : '';
            $jurusan = isset($row[2]) ? trim($row[2]) : '';
            $prodiName = isset($row[3]) ? trim($row[3]) : '';
            $semester = isset($row[4]) ? trim($row[4]) : '';

            // Jika baris kosong seluruhnya, lewati
            if (empty($name) && empty($nimNip) && empty($jurusan) && empty($prodiName) && empty($semester)) {
                continue;
            }

            $rowNum = $i + 1;

            if (empty($name)) {
                $errors[] = "Baris {$rowNum}: Nama Lengkap wajib diisi.";
            }
            if (empty($nimNip)) {
                $errors[] = "Baris {$rowNum}: NIM / NIP wajib diisi.";
            }
            if (empty($jurusan)) {
                $errors[] = "Baris {$rowNum}: Jurusan wajib diisi.";
            }
            if (empty($prodiName)) {
                $errors[] = "Baris {$rowNum}: Program Studi wajib diisi.";
            } else {
                // Cocokkan prodi case-insensitive
                $prodiMatch = $prodis->first(function($p) use ($prodiName) {
                    return strtolower($p->nama_prodi) === strtolower($prodiName);
                });
                if (!$prodiMatch) {
                    $errors[] = "Baris {$rowNum}: Program Studi '{$prodiName}' tidak terdaftar di database.";
                }
            }
        }

        // Jika ada kesalahan validasi baris, batalkan import dan tampilkan error
        if (count($errors) > 0) {
            return back()->withInput()->with('import_errors', $errors);
        }

        // Tahap 2: Lakukan import secara transaksional
        DB::beginTransaction();
        try {
            for ($i = $startIndex; $i < $totalRows; $i++) {
                $row = $rows[$i];
                
                $name = isset($row[0]) ? trim($row[0]) : '';
                $nimNip = isset($row[1]) ? trim($row[1]) : '';
                $jurusan = isset($row[2]) ? trim($row[2]) : '';
                $prodiName = isset($row[3]) ? trim($row[3]) : '';
                $semester = isset($row[4]) ? trim($row[4]) : '';

                if (empty($name) && empty($nimNip) && empty($jurusan) && empty($prodiName) && empty($semester)) {
                    continue;
                }

                // Tentukan peran
                $isMahasiswa = !empty($semester);
                $roleId = $isMahasiswa ? $roleMahasiswa->role_id : $roleDosen->role_id;
                $email = $nimNip . '@sipus.polnep.ac.id';
                $password = 'sipus' . $nimNip;

                // Cek keunikan NIM/NIP dan email di database untuk fitur "Abaikan / Skip"
                $emailExists = User::where('email', $email)->exists();
                $nimNipExists = false;

                if ($isMahasiswa) {
                    $nimNipExists = Mahasiswa::where('nim', $nimNip)->exists();
                } else {
                    $nimNipExists = Dosen::where('nip', $nimNip)->exists();
                }

                if ($emailExists || $nimNipExists) {
                    $skippedCount++;
                    continue;
                }

                // Dapatkan Prodi ID
                $prodi = $prodis->first(function($p) use ($prodiName) {
                    return strtolower($p->nama_prodi) === strtolower($prodiName);
                });

                // Buat User
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role_id' => $roleId,
                ]);

                // Buat profil peran
                if ($isMahasiswa) {
                    Mahasiswa::create([
                        'user_id' => $user->user_id,
                        'prodi_id' => $prodi->prodi_id,
                        'nim' => $nimNip,
                        'semester' => $semester,
                    ]);
                } else {
                    Dosen::create([
                        'user_id' => $user->user_id,
                        'nip' => $nimNip,
                        'prodi_id' => $prodi->prodi_id,
                    ]);
                }

                $importedCount++;
            }

            // Log aktivitas ke ActivityLog
            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity' => "Melakukan import user via Excel. Berhasil: {$importedCount}, Dilewati (Duplikat): {$skippedCount}.",
            ]);

            DB::commit();

            $message = "Proses import selesai. Berhasil menambahkan {$importedCount} user baru.";
            if ($skippedCount > 0) {
                $message .= " Sebanyak {$skippedCount} data dilewati karena NIM/NIP sudah terdaftar.";
            }

            return redirect()->route('admin.users.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['file' => 'Terjadi kesalahan sistem saat menyimpan data: ' . $e->getMessage()]);
        }
    }
}
