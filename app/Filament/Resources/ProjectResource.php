<?php

namespace App\Filament\Resources;
use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // public function slugify($text, string $divider = '-')
    // {
    // // replace non letter or digits by divider
    // $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // // transliterate
    // $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // // remove unwanted characters
    // $text = preg_replace('~[^-\w]+~', '', $text);

    // // trim
    // $text = trim($text, $divider);

    // // remove duplicate divider
    // $text = preg_replace('~-+~', $divider, $text);

    // // lowercase
    // $text = strtolower($text);

    // if (empty($text)) {
    //     return 'n-a';
    // }

    // return $text;
    // }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make("title")->label('Title')->required()
                ->reactive()
                ->debounce()
                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make("slug")->label('Permalink')->required(),
                Forms\Components\Select::make("category")->label('Category')->options([
                    'photo' => 'Photography',
                    'film' => 'Film',
                    'prod' => 'Services',
                ])->required(),
                Forms\Components\RichEditor::make("description")->label('Description')->required(),
                Forms\Components\FileUpload::make("cover_image")->label('Cover')->required(),
                Forms\Components\FileUpload::make("files")->label('Assets')->multiple()->reorderable()->maxSize(2097152),

                Forms\Components\Select::make('file_path')
                    ->label('Seleziona file esistente')
                    ->options(function () {
                        // Leggi i file dalla tua cartella
                        $files = Storage::disk('local')->files('./public');
                        
                        // Mappa path => nome leggibile
                        return collect($files)->mapWithKeys(function ($file) {
                            return [$file => basename($file)];
                        })->toArray();
                    })
                    ->searchable()
             
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Title'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
