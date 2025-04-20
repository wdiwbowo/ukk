@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @if (session('success'))
            <script>
           document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'success',
                text: '{{ session("success") }}'
            })
        });
            </script>
        @endif

        <!-- Card untuk Diagram Batang & Diagram Bulat -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Laporan Data</h5>
            </div>
            <div class="card-body">
                <!-- Teks Selamat Datang di Atas Diagram -->
                <h4 class="text-center mb-3">Selamat Datang, Admin</h4>

                <div class="row align-items-center">
                    <!-- Diagram Batang -->
                    <div class="col-md-8">
                        <canvas id="barChart"></canvas>
                    </div>
                    <!-- Diagram Bulat (diperkecil) -->
                    <div class="col-md-4 text-center">
                        <canvas id="pieChart" style="max-width: 200px; max-height: 200px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var glassyBlue = "rgba(54, 162, 235, 0.5)"; 

            var barChartCtx = document.getElementById("barChart").getContext("2d");
            new Chart(barChartCtx, {
                type: "bar",
                data: {
                    labels: ["Januari", "Februari", "Maret", "April", "Mei"],
                    datasets: [{
                        label: "Penjualan",
                        data: [12, 19, 3, 5, 10],
                        backgroundColor: glassyBlue,
                        borderColor: "rgba(54, 162, 235, 0.8)",
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                color: "#333"
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var glassyColors = [
                "rgba(255, 99, 132, 0.5)",
                "rgba(54, 162, 235, 0.5)",
                "rgba(255, 206, 86, 0.5)"
            ];

            var pieChartCtx = document.getElementById("pieChart").getContext("2d");
            new Chart(pieChartCtx, {
                type: "pie",
                data: {
                    labels: ["Produk A", "Produk B", "Produk C"],
                    datasets: [{
                        data: [30, 50, 20],
                        backgroundColor: glassyColors,
                        borderColor: [
                            "rgba(255, 99, 132, 0.8)",
                            "rgba(54, 162, 235, 0.8)",
                            "rgba(255, 206, 86, 0.8)"
                        ],
                        borderWidth: 1
                    }]
                }
            });
        });
    </script>
@endsection
