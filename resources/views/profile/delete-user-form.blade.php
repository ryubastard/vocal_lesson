<x-action-section>
    <x-slot name="title">
        アカウント削除
    </x-slot>

    <x-slot name="description">
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            アカウントを削除します。予約している最新のレッスンがある場合はキャンセル後、アカウントを削除できます。
        </div>

        <div class="mt-5">
            @if ($reservations->isNotEmpty())
            <div class="max-w-xl text-sm text-red-600">
                <b>予約している最新のレッスンがあります。マイページより削除処理を行ってください。</b>
                <div class="flex items-center justify-left mt-4">
                    <x-button onclick="location.href='{{ route('mypage.index') }}'" class="mr-3">マイページ</x-button>
                </div>
            </div>
            @elseif ($lessons->isNotEmpty())
            <div class="max-w-xl text-sm text-red-600">
                <b>開催予定のレッスンがあります。レッスン管理より削除処理を行ってください。</b>
                <div class="flex items-center justify-left mt-4">
                    <x-button onclick="location.href='{{ route('lessons.index') }}'" class="mr-3">レッスン管理</x-button>
                </div>
            </div>
            @else
            <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                アカウント削除
            </x-danger-button>
            @endif
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-dialog-modal wire:model="confirmingUserDeletion">
            <x-slot name="title">
                アカウント削除
            </x-slot>

            <x-slot name="content">
                アカウントを削除してよろしいですか？もし予約している最新のレッスンがある場合はキャンセル後、アカウントを削除できます。アカウントを削除するには、パスワードを入力してください。

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input type="password" class="mt-1 block w-3/4" autocomplete="current-password" placeholder="{{ __('Password') }}" x-ref="password" wire:model.defer="password" wire:keydown.enter="deleteUser" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    キャンセル
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="deleteUser" wire:loading.attr="disabled">
                    アカウント削除
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>