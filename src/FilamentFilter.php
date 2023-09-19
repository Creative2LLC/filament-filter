<?php

namespace Creative2LLC\FilamentFilter;

use Closure;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Schema;

class FilamentFilter
{
    public static function applyQuery($query, $conditionals)
    {
        $tableName = $query->getModel()->getTable();

        foreach ($conditionals as $index => $conditional) {
            $query->where(function ($subQuery) use ($tableName, $conditional) {
                foreach ($conditional['data']['and_condition'] as $key => $q) {
                    if ($q['column'] == 'custom:field') {
                        $q['column'] = $q['custom_column'];
                    }

                    $column = explode('->', $q['column']);

                    if (Schema::hasColumn($tableName, $column[0])) {
                        if (isset($column[1])) {
                            $rawQuery = "JSON_EXTRACT(LOWER({$column[0]}), '$.{$column[1]}') {$q['operator']} ?";
                        } else {
                            $rawQuery = "LOWER({$column[0]}) {$q['operator']} ?";
                        }

                        if (in_array($q['operator'], ['like', 'not like'])) {
                            $value = '%'.$q['value'].'%';
                        } else {
                            $value = $q['value'];
                        }

                        $value = strtolower($value);

                        if ($conditional['type'] == 'and') {
                            $subQuery->whereRaw($rawQuery, $value);
                        } else {
                            $subQuery->orWhereRaw($rawQuery, $value);
                        }
                    }
                }
            });
        }

        // ray($query->toSql());

        return $query;
    }

    public static function field($columns = [], $label = 'conditions')
    {
        $conditionSchema = [
            Repeater::make('and_condition')
                ->schema([
                    Grid::make(3)
                        ->schema([
                            Fieldset::make('Column')
                                ->schema([
                                    Select::make('column')
                                        ->options([
                                            ...$columns,
                                            'custom:field' => 'Custom Column',
                                            'custom:field' => 'Other Column',
                                        ])
                                        ->searchable()
                                        ->reactive()
                                        ->columnSpanFull(),
                                    TextInput::make('custom_column')
                                        ->hidden(fn (Closure $get) => $get('column') !== 'custom:field')
                                        ->columnSpanFull(),
                                ])
                                ->columnSpan(1),
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
