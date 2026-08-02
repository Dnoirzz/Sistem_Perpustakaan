@props(['pagination' => null, 'containerClass' => ''])

<section class="hidden lg:block bg-white shadow-sm border border-slate-200 rounded-none overflow-hidden {{ $containerClass }}">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100 border-b border-slate-200 text-slate-700">
                    {{ $headers }}
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if($pagination)
        <div class="p-6 border-t border-slate-200 bg-slate-50/80">
            {!! $pagination !!}
        </div>
    @endif
</section>
