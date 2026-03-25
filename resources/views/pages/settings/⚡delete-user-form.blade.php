<?php

use Livewire\Component;

new class extends Component {}; ?>

<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <flux:heading>{{ __('Delete account') }}</flux:heading>
        <flux:subheading>{{ __('Delete your account and all of its resources') }}</flux:subheading>
    </div>

    @if (auth()->user()->isGuest())
        <flux:callout variant="warning" icon="exclamation-triangle">
            <flux:callout.heading>ゲストアカウント</flux:callout.heading>
            <flux:callout.text>ゲストアカウントは削除できません。</flux:callout.text>
        </flux:callout>
    @else
        <flux:modal.trigger name="confirm-user-deletion">
            <flux:button variant="danger" data-test="delete-user-button">
                {{ __('Delete account') }}
            </flux:button>
        </flux:modal.trigger>

        <livewire:pages::settings.delete-user-modal />
    @endif
</section>
