@foreach($informations as $information)
<div style="display: flex; justify-content: center; align-items: center; flex-wrap: wrap; margin: 16px auto; max-width: 960px;">
    @php
    $image = $information->image1 ?? 'no_image.jpg';
    @endphp

    @if ($image === 'no_image.jpg')
    <div><img src="{{ asset('images/no_image.jpg') }}" width="360" height="auto" style="margin-right: 16px;"></div>
    @else
    <div><img src="{{ asset('storage/images/'.$image) }}" width="360" height="auto" style="margin-right: 16px;"></div>
    @endif
    <div style="flex: 1;">
        <b style="font-size: 1.2em; font-weight: bold;">{{ $information->name }}</b>
        <p style="margin-top: 4px;">{!! nl2br(e($information->information)) !!}…</p>
        <div class="flex w-full justify-center items-end">
            <form method="GET" action="{{ route('information', ['id' => $information->user_id] ) }}">
                <button class="bg-cyan-200 text-white py-2 px-6 rounded-full hover:bg-cyan-300">詳細を見る</button>
            </form>
        </div>
    </div>
</div>
@endforeach