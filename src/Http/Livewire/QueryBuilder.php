<?php

namespace Creative2LLC\FilamentFilter\Http\Livewire;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Component as FilamentComponent;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class QueryBuilder extends Component implements HasForms
{
    use InteractsWithForms;

    public $columns = [];

    public $resetable = false;

    public function mount($columns = [])
    {
        $this->columns = $columns;
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Filters')
                ->collapsible()
                ->schema([
                    Builder::make('conditions')
                        ->blocks([
                            Block::make('and')
                                ->label('+ And')
                                ->schema($this->getConditionSchema()),
                            Block::make('or')
                                ->label('+ Or')
                                ->schema($this->getConditionSchema()),
                        ])->registerListeners([
                            'builder::createItem' => [
                                function (FilamentComponent $component, string $statePath): void {
                                    $this->resetable = true;
                                },
                            ],
                        ]),
                    // Repeater::make('conditions')
                    //     ->schema()
                    //     ->defaultItems(0)
                    //     ->createItemButtonLabel('Add new condition')
                ]),
        ];
    }

    protected function getConditionSchema(): array
    {
        return [
            Repeater::make('and_condition')
                ->schema([
                    Grid::make(3)
                        ->schema([
                            Select::make('column')
                                ->options($this->columns)
                                ->searchable(),
                            Select::make('operator')
                                ->options([
                                    '=' => 'Equals',
                                    '!=' => 'Does not equal',
                                    // 'starts with' => 'Starts with',
                                    // 'ends with' => 'Ends with',
                                    // 'not start with' => 'Does not start with',
                                    // 'not end with' => 'Does not end with',
                                    '>' => 'Greater than',
                                    '>=' => 'Greater than or equal to',
                                    '<' => 'Less than',
                                    '<=' => 'Less than or equal to',
                                    'like' => 'Contains',
                                    'not like' => 'Does not contain',
                                    'in' => 'In',
                                    'not in' => 'Not in',
                                ])
                                ->searchable(),
                            TextInput::make('value'),
                        ]),
                ])
                ->createItemButtonLabel('Add new condition'),

        ];
    }

    public function submit()
    {
        //build query

        $state = $this->form->getState();

        $this->emit('query', $state['conditions']);
    }

    public function resetQuery()
    {
        $query = [];
        $this->emit('query', $query);
        $this->resetable = false;
    }

    public function render()
    {
        return view('award-system::livewire.query-builder');
    }
}
