document.addEventListener("DOMContentLoaded", function () {
    // Inisialisasi filter
    const filterForm = document.getElementById("filterForm");

    // Load data awal
    loadData();

    // Event listener untuk filter
    filterForm.addEventListener("submit", function (e) {
        e.preventDefault();
        loadData();
    });

    // Export PDF
    document.getElementById("exportPdf").addEventListener("click", function () {
        // Implementasi export PDF
        alert("Fitur export PDF akan diimplementasikan");
    });

    // Fungsi load data
    function loadData() {
        const formData = new FormData(filterForm);
        const bulan = formData.get("bulan");
        const tahun = formData.get("tahun");

        // Contoh data statis (ganti dengan AJAX ke server)
        const response = {
            stats: {
                totalUser: 45,
                userBaru: 3,
                totalPengadaan: "Rp 125.000.000",
                totalTransaksi: 28,
                totalAktivitas: 342,
                totalLogin: 210,
                topVendor: "PT. Sumber Jaya",
                vendorTransaksi: 8,
            },
            userData: {
                labels: ["Minggu 1", "Minggu 2", "Minggu 3", "Minggu 4"],
                data: [8, 12, 15, 10],
            },
            pengadaanData: {
                labels: ["Elektronik", "Furniture", "ATK", "Lainnya"],
                data: [45, 30, 15, 10],
            },
            aktivitas: [
                {
                    tanggal: "01-04-2025",
                    user: "admin",
                    aktivitas: "Login",
                    keterangan: "IP: 192.168.1.1",
                },
                {
                    tanggal: "01-04-2025",
                    user: "om",
                    aktivitas: "Pengadaan",
                    keterangan: "PO #12345",
                },
                {
                    tanggal: "02-04-2025",
                    user: "Fo",
                    aktivitas: "Update Profile",
                    keterangan: "Mengubah email",
                },
            ],
        };

        // Update statistik
        updateStats(response.stats);

        // Render charts
        renderCharts(response.userData, response.pengadaanData);

        // Render tabel
        renderTable(response.aktivitas);
    }

    function updateStats(stats) {
        document.getElementById("totalUser").textContent = stats.totalUser;
        document.getElementById("userBaru").textContent = stats.userBaru;
        document.getElementById("totalPengadaan").textContent =
            stats.totalPengadaan;
        document.getElementById("totalTransaksi").textContent =
            stats.totalTransaksi;
        document.getElementById("totalAktivitas").textContent =
            stats.totalAktivitas;
        document.getElementById("totalLogin").textContent = stats.totalLogin;
        document.getElementById("topVendor").textContent = stats.topVendor;
        document.getElementById("vendorTransaksi").textContent =
            stats.vendorTransaksi;
    }

    function renderCharts(userData, pengadaanData) {
        // User Chart
        const userCtx = document.getElementById("userChart").getContext("2d");
        if (window.userChart) {
            window.userChart.destroy();
        }
        window.userChart = new Chart(userCtx, {
            type: "line",
            data: {
                labels: userData.labels,
                datasets: [
                    {
                        label: "Aktivitas User",
                        data: userData.data,
                        backgroundColor: "rgba(54, 162, 235, 0.2)",
                        borderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 2,
                        tension: 0.4,
                    },
                ],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });

        // Pengadaan Chart
        const pengadaanCtx = document
            .getElementById("pengadaanChart")
            .getContext("2d");
        if (window.pengadaanChart) {
            window.pengadaanChart.destroy();
        }
        window.pengadaanChart = new Chart(pengadaanCtx, {
            type: "doughnut",
            data: {
                labels: pengadaanData.labels,
                datasets: [
                    {
                        data: pengadaanData.data,
                        backgroundColor: [
                            "rgba(255, 99, 132, 0.7)",
                            "rgba(54, 162, 235, 0.7)",
                            "rgba(255, 206, 86, 0.7)",
                            "rgba(75, 192, 192, 0.7)",
                        ],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
            },
        });
    }

    function renderTable(data) {
        const tbody = document.querySelector("#tabelAktivitas tbody");
        tbody.innerHTML = "";

        data.forEach((item) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${item.tanggal}</td>
                <td>${item.user}</td>
                <td>${item.aktivitas}</td>
                <td>${item.keterangan}</td>
            `;
            tbody.appendChild(row);
        });
    }
});
