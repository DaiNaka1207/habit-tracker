<?php

use App\Models\Habit;
use Livewire\Component;

new class extends Component
{
    public string $name = '';
    public string $color = '#3b82f6';

    public function save(): void
    {
        $this->validate([
            'name'  => 'required|string|max:255',
            'color' => 'required|string|size:7',
        ]);

        auth()->user()->habits()->create([
            'name'  => $this->name,
            'color' => $this->color,
        ]);

        $this->reset(['name', 'color']);
        $this->dispatch('habit-updated');
    }

    public function delete(int $habitId): void
    {
        auth()->user()->habits()->findOrFail($habitId)->delete();
        $this->dispatch('habit-updated');
    }

    public function with(): array
    {
        return [
            'habits' => auth()->user()->habits()->latest()->get(),
        ];
    }
};
?>

<div>
    <div class="flex flex-row items-end gap-2.5">
        <div class="flex-1">
            <flux:input wire:model="name" label="習慣名" placeholder="例：毎朝ランニング" />
        </div>
        <div class="w-12">
            <flux:input wire:model="color" type="color" label="カラー" />
        </div>
        <flux:button wire:click="save" variant="primary">追加</flux:button>
    </div>

    <div class="mt-4">
        @foreach ($habits as $habit)
            <div class="flex items-center justify-between border-t border-neutral-100 py-2 dark:border-neutral-800">
                <span class="flex items-center gap-2">
                    <span class="inline-block h-4 w-1 rounded-full" style="background-color: {{ $habit->color }}"></span>
                    {{ $habit->name }}
                </span>
                <flux:button wire:click="delete({{ $habit->id }})" variant="danger" size="sm">削除</flux:button>
            </div>
        @endforeach
    </div>
</div>
