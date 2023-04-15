<x-form-section submit="updatePassword">
    <x-slot name="title">
        パスワード変更
    </x-slot>

    <x-slot name="description">
        アカウントの安全性を保つために、長くてランダムなパスワードを使用していることを確認してください。
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="現在のパスワード" />
            <x-input id="current_password" type="password" class="mt-1 block w-full"
                wire:model.defer="state.current_password" autocomplete="current-password" />
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="新しいパスワード" />
            <x-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password"
                autocomplete="new-password" />
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="パスワードの確認" />
            <x-input id="password_confirmation" type="password" class="mt-1 block w-full"
                wire:model.defer="state.password_confirmation" autocomplete="new-password" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            パスワードを変更しました。
        </x-action-message>

        <x-button>
            保存
        </x-button>
    </x-slot>
</x-form-section>
