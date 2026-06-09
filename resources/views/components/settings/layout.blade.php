<div class="flex items-start max-md:flex-col">
    <div class="me-8 w-full pb-4 md:w-[220px]">
        <flux:navlist aria-label="{{ __('Settings') }}">
            <flux:navlist.item :href="route('profile.edit')" wire:navigate>
                <flux:icon.user-circle class="size-4" />
                {{ __('Profile') }}
            </flux:navlist.item>
            <flux:navlist.item :href="route('security.edit')" wire:navigate>
                <flux:icon.shield-check class="size-4" />
                {{ __('Security') }}
            </flux:navlist.item>
            <flux:navlist.item :href="route('appearance.edit')" wire:navigate>
                <flux:icon.swatch class="size-4" />
                {{ __('Appearance') }}
            </flux:navlist.item>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading class="text-xl">{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-6 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
