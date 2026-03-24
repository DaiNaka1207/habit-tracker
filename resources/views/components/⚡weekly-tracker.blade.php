<?php

use App\Models\HabitLog;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    #[On('habit-updated')]
    public function refresh(): void {}

    public function toggle(int $habitId, string $date): void
    {
        $log = HabitLog::where('habit_id', $habitId)
            ->where('date', $date)
            ->first();

        if ($log) {
            $log->delete();
        } else {
            HabitLog::create([
                'habit_id' => $habitId,
                'date'     => $date,
            ]);
        }
    }

    public function with(): array
    {
        $weekDates = collect(range(0, 6))->map(function ($i) {
            $date = now()->startOfWeek()->addDays($i);
            return [
                'date'  => $date->format('Y-m-d'),
                'label' => $date->locale('ja')->isoFormat('ddd'),
                'day'   => $date->format('d'),
            ];
        });

        return [
            'habits'    => auth()->user()->habits()->with('logs')->get(),
            'weekDates' => $weekDates,
        ];
    }
};
?>

<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr>
                <th class="py-2 pr-4 text-left font-medium text-neutral-500">習慣</th>
                @foreach ($weekDates as $week)
                    <th class="w-12 py-2 text-center font-medium text-neutral-500">
                        <div>{{ $week['label'] }}</div>
                        <div class="text-xs text-neutral-400">{{ $week['day'] }}</div>
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($habits as $habit)
                <tr class="border-t border-neutral-100 dark:border-neutral-800">
                    <td class="py-3 pr-4">
                        <span class="flex items-center gap-2">
                            <span class="inline-block h-4 w-1 rounded-full" style="background-color: {{ $habit->color }}"></span>
                            {{ $habit->name }}
                        </span>
                    </td>
                    @foreach ($weekDates as $week)
                        @php $checked = $habit->logs->contains('date', $week['date']); @endphp
                        <td class="py-3 text-center">
                            <button wire:click="toggle({{ $habit->id }}, '{{ $week['date'] }}')">
                                {{ $checked ? '✅' : '⬜' }}
                            </button>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
