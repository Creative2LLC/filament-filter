<?php

namespace Creative2LLC\FilamentFilter;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class FilamentFilter
{
    public static function applyQuery($query, $conditionals)
    {
        foreach ($conditionals as $index => $conditional) {
            $subQuery = [];

            foreach ($conditional['data']['and_condition'] as $key => $q) {
                $subQuery[] = [$q['column'], $q['operator'], $q['value']];
            }

            if ($conditional['type'] == 'and') {
                $query->where($subQuery);
            } else {
                $query->orWhere($subQuery);
            }
        }

        return $query;
    }

    public static function field($columns = [], $label = 'conditions')
    {
        $conditionSchema = [
            Repeater::make('and_condition')
                ->schema([
                    Grid::make(3)
                        ->schema([
                            Select::make('column')
                                ->options($columns)
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

        return Builder::make($label)
                ->blocks([
                    Block::make('and')
                        ->label('+ And')
                        ->schema($conditionSchema),
                    Block::make('or')
                        ->label('+ Or')
                        ->schema($conditionSchema),
                ]);
    }
}
