<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="text-center">
        <h1>bilangan akar kuadrat</h1>
        <form id="kuadrat-form">
            @csrf
            <p>Masukan Bilangan Yang Ingin Di Proses</p>
            <input type="text" id="bilangan" name="bilangan">
            <button type="submit" class="btn btn-success">Submit</button>
        </form>

        <!-- Tampilkan Hasil -->
        <div id="hasil">
            <!-- Hasil akan ditampilkan di sini -->
        </div>

        <!-- Tampilkan waktu eksekusi -->
        <div id="waktu-eksekusi">
            <!-- Waktu eksekusi akan ditampilkan di sini -->
        </div>
        <h1 class="mt-5">Data Bilangan</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Bilangan</th>
                    <th>Akar Kuadrat</th>
                    <th>Waktu Eksekusi (milidetik)</th>
                </tr>
            </thead>
            <tbody id="data-table">
                <!-- Data akan ditampilkan di sini -->
            </tbody>
        </table>

    </div>

    <!-- Menggunakan Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Fungsi untuk mengambil dan menampilkan data dari server
        async function fetchData() {
            try {
                const response = await axios.get('/test'); // Ganti URL sesuai dengan endpoint Anda
                const data = response.data;

                const dataTable = document.getElementById('data-table');
                dataTable.innerHTML = '';

                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.id}</td>
                        <td>${item.bilangan}</td>
                        <td>${item.akar_kuadrat}</td>
                        <td>${item.waktu} ms</td>
                    `;
                    dataTable.appendChild(row);
                });
            } catch (error) {
                console.error(error);
            }
        }

        // Panggil fungsi fetchData saat halaman dimuat
        fetchData();
    </script>

    <script>
        // Temukan elemen formulir dan hasil
        const form = document.getElementById('kuadrat-form');
        const bilanganInput = document.getElementById('bilangan');
        const hasilDiv = document.getElementById('hasil');
        const waktuEksekusiDiv = document.getElementById(
            'waktu-eksekusi'); // Tambahkan elemen untuk menampilkan waktu eksekusi
        const csrfToken = "{{ csrf_token() }}";

        // Tangani pengiriman formulir
        form.addEventListener('submit', async (e) => {
            e.preventDefault(); // Mencegah pengiriman formulir berdasarkan aksi default

            const bilangan = bilanganInput.value;

            // Catat waktu awal eksekusi
            // Kirim permintaan POST ke server dengan menggunakan token CSRF menggunakan Axios
            try {
                const response = await axios.post('/test', {
                    bilangan
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    }
                });

                const data = response.data;
                const {
                    bilangan_terakhir,
                    hasil_kuadrat,
                    waktu_eksekusi
                } = data;

                // Tampilkan hasil di dalam div
                hasilDiv.innerHTML = `
                    <p>Hasil Kuadrat: ${hasil_kuadrat}</p>
                `;

                // Tampilkan waktu eksekusi di dalam div waktu-eksekusi
                waktuEksekusiDiv.innerHTML = `Waktu Eksekusi: ${waktu_eksekusi} milidetik`;

                fetchData();

            } catch (error) {
                hasilDiv.innerHTML = 'Terjadi kesalahan. Coba lagi nanti.';
                console.error(error);
            }

        });
    </script>
</body>

</html>
