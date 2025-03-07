protected $middlewareGroups = [
    'web' => [
        // ... middleware lainnya
        \App\Http\Middleware\SetDefaultSekolah::class,
    ],
];