<!-- resources/views/your-view.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                // Decode JSON string to an array
                $pageData = json_decode($page, true);
            @endphp

            @foreach ($pageData as $item)
                <div class="bg-white border rounded-lg shadow-lg overflow-hidden">
                    <img class="w-full h-48 object-cover" src="{{ asset('storage/'.$item['data']['attachment']) }}" alt="{{ $item['data']['name'] }}">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800">{{ $item['data']['name'] }}</h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>
