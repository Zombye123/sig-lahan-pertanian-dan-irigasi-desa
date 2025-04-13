<div class="container mt-4">
    <h3><?= $title ?></h3>

    <!-- Table for displaying plant data -->
    <table class="table table-bordered mt-3">
        <thead class="bg-gradient-secondary">
            <tr>
                <th>No</th>
                <th>Tahun</th>
                <th>Jenis Tanaman</th>
                <th>Jumlah Lahan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($grafik as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->tahun ?></td>
                <td><?= $row->isi_lahan ?></td>
                <td><?= $row->jumlah ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Grafik Tanaman per Tahun -->
    <canvas id="grafikTanaman" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikTanaman').getContext('2d');

// Data from the controller
let data = <?= json_encode($grafik) ?>;

// Get unique years
let labels = [...new Set(data.map(item => item.tahun))];

// Get unique plant types
let jenis = [...new Set(data.map(item => item.isi_lahan))];

// Prepare dataset for each plant type
let datasets = jenis.map(jenisItem => {
    return {
        label: jenisItem,
        data: labels.map(tahun => {
            let found = data.find(d => d.tahun == tahun && d.isi_lahan == jenisItem);
            return found ? found.jumlah : 0;  // Return count if found, otherwise 0
        }),
        backgroundColor: '#' + Math.floor(Math.random() * 16777215).toString(16),
        borderColor: '#000',
        borderWidth: 1
    }
});

// Create the chart
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: datasets
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Grafik Tanaman per Tahun'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Jumlah Lahan'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Tahun'
                }
            }
        }
    }
});
</script>
