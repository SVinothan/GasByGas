<x-filament-panels::page.simple>
    <a href="{{route('filament.admin.auth.login')}}" class="fi-link group/link relative inline-flex items-center justify-center outline-none fi-size-md fi-link-size-md gap-1.5 fi-color-custom fi-color-primary fi-ac-action fi-ac-link-action">
        <span class="font-semibold text-sm text-custom-600 dark:text-custom-400 group-hover/link:underline group-focus-visible/link:underline" style="--c-400:var(--primary-400);--c-600:var(--primary-600);">
            Sign in to your account
        </span>
    </a> 
    <x-filament-panels::form wire:submit="Submit">
    {{$this->form}}
     
</x-filament-panels::form>         
</x-filament-panels::page.simple>


