<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kredit Koperasi - Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine.js" defer></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Navbar -->
        <nav class="bg-blue-600 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-white text-xl font-bold">Kredit Koperasi</h1>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Alert Messages -->
            @if (session('error'))
                <div class="animate__animated animate__fadeIn bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if (session('success'))
                <div class="animate__animated animate__fadeIn bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6 animate__animated animate__fadeInUp">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Status Kredit</h2>
                <div class="flex items-center">
                    <div class="text-3xl font-bold text-blue-600">Rp {{ number_format($status->available, 0, ',', '.') }}</div>
                    <span class="ml-2 text-gray-600">tersedia</span>
                </div>
            </div>

            <!-- Members and Credits Table -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6 animate__animated animate__fadeInUp">
                <h2 class="text-lg font-semibold text-gray-700 p-6 pb-0">Anggota dan Kredit</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Max Kredit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Allocated</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Need</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($members as $member)
                                @foreach ($member->credits as $credit)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $member->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($member->max_credit, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($credit->allocated, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($credit->calculateNeed(), 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Actions Grid -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Allocate Credit -->
                <div class="bg-white rounded-lg shadow-sm p-6 animate__animated animate__fadeInUp">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Alokasi Kredit</h2>
                    <form method="POST" action="{{ route('credits.allocate') }}" class="space-y-4">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200 transform hover:scale-105">
                            Alokasi Kredit
                        </button>
                    </form>
                </div>

                <!-- Request Credit -->
                <div class="bg-white rounded-lg shadow-sm p-6 animate__animated animate__fadeInUp">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Request Kredit</h2>
                    <form method="POST" action="{{ route('credits.request') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="credit_id" class="block text-sm font-medium text-gray-700">Pilih Anggota</label>
                            <select name="credit_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                @foreach ($members as $member)
                                    @foreach ($member->credits as $credit)
                                        <option value="{{ $credit->id }}">
                                            {{ $member->name }} - Need: Rp {{ number_format($credit->calculateNeed(), 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah Kredit</label>
                            <div class="mt-1">
                                <input type="number" name="amount" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200 transform hover:scale-105">
                            Ajukan Kredit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add number formatting to input
        const amountInput = document.querySelector('input[name="amount"]');
        amountInput.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            if (value === '') return;
            this.value = new Intl.NumberFormat('id-ID').format(value);
        });
    </script>
</body>
</html>
