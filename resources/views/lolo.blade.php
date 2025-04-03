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

  @php
                // Decode JSON string to an array
                $page = json_decode($page, true);
            @endphp

    <div class="container mx-auto py-8">
        <div class="space-y-8">
            @foreach ($page as $item)
                @if ($item['type'] == 'my')
                    <!-- First Block: Name and Image -->
                    <div class="bg-white border rounded-lg shadow-lg overflow-hidden">
                        <img class="w-full h-48 object-cover" src="{{ asset('storage/'.$item['data']['attachment']) }}" alt="{{ $item['data']['name'] }}">
                        <div class="p-4">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $item['data']['name'] }}</h3>
                        </div>
                    </div>
                @elseif ($item['type'] == 'services')
                    <!-- Second Block: Services Title and Repeater -->
                    <div class="bg-white border rounded-lg shadow-lg overflow-hidden p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $item['data']['title'] }}</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            @foreach ($item['data']['services_list'] as $service)
                                <div class="bg-gray-100 border rounded-lg shadow-sm p-4">
                                    <img class="w-full h-40 object-cover rounded-lg mb-4" src="{{ asset('storage/'.$service['image']) }}" alt="{{ $service['text'] }}">
                                    <h3 class="text-xl font-semibold text-gray-800">{{ $service['text'] }}</h3>
                                    <a href="{{ $service['button_url'] }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg text-center hover:bg-blue-700">Visit</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

</body>
</html>

