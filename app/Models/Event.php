<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use App\Models\User;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'location',
        'price',
        'max_people',
        'start_date',
        'end_date',
        'is_visible',
    ];

    protected function eventDate(): Attribute //データを加工して取得する（アクセサ）
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->start_date)->format('Y年m月d日'),
        );
    }
    protected function startTime(): Attribute //アクセサ
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->start_date)->format('H時i分'),
        );
    }
    protected function endTime(): Attribute //アクセサ
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->end_date)->format('H時i分'),
        );
    }
    protected function editEventDate(): Attribute //日付の重複チェック
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->start_date)->format('Y-m-d'),
        );
    }

    public function users() // リレーションの設定
    {
        return $this->belongsToMany(User::class, 'reservations')
            ->withPivot('id', 'number_of_people', 'canceled_date');
    }
}
