<div>
    <div class="text-center text-sm">
        レッスンの日付を選択してください。日付は最大60日先まで選択可能です。
    </div>
    <input id="calendar" class="block mt-1 mb-2 mx-auto" type="text" name="calendar" value="{{ $currentDate }}"
        wire:change="getDate($event.target.value)" />

    <div class="flex mx-auto">
        <x-calendar-time />
        @for ($i = 0; $i < 7; $i++)
            <div class="w-32">
                <div class="py-1 px-2 border border-gray-200 text-center">{{ $currentWeek[$i]['day'] }}</div>
                <div class="py-1 px-2 border border-gray-200 text-center">{{ $currentWeek[$i]['dayOfWeek'] }}</div>
                @for ($j = 0; $j < 21; $j++)
                    @if ($lessons->isNotEmpty())
                        @if (!is_null($lessons->firstWhere('start_date', $currentWeek[$i]['checkDay'] . ' ' . \Constant::LESSON_TIME[$j])))
                            @php
                                $lessonId = $lessons->firstWhere('start_date', $currentWeek[$i]['checkDay'] . ' ' . \Constant::LESSON_TIME[$j])->id;
                                $lessonName = $lessons->firstWhere('start_date', $currentWeek[$i]['checkDay'] . ' ' . \Constant::LESSON_TIME[$j])->name;
                                $lessonInfo = $lessons->firstWhere('start_date', $currentWeek[$i]['checkDay'] . ' ' . \Constant::LESSON_TIME[$j]);
                                $lessonPeriod = \Carbon\Carbon::parse($lessonInfo->start_date)->diffInMinutes($lessonInfo->end_date) / 30 - 1;
                            @endphp
                            <a href="{{ route('lessons.detail', ['id' => $lessonId]) }}">
                                <div class="py-1 px-2 h-8 border border-gray-200 text-xs bg-blue-100">
                                    {{ $lessonName }}
                                </div>
                            </a>
                            @if ($lessonPeriod > 0)
                                @for ($k = 0; $k < $lessonPeriod; $k++)
                                    <div class="py-1 px-2 h-8 border border-gray-200 bg-blue-100">
                                    </div>
                                @endfor
                                @php $j += $lessonPeriod @endphp
                            @endif
                        @else
                            <div class="py-1 px-2 h-8 border border-gray-200"></div>
                        @endif
                    @else
                        <div class="py-1 px-2 h-8 border border-gray-200"></div>
                    @endif
                @endfor
            </div>
        @endfor
    </div>
</div>
