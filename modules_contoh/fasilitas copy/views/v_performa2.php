<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="<?= base_url('assets_v2/baru/bootstrap-5.3.7/bootstrap.min.css') ?>" rel="stylesheet">
    
      <style>
        /* Full page background */
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
        .pcoded-content {
            background-image: url(<?= base_url('assets/biru2.jpg') ?>);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        /* Card styling with transparency */
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
        }
        
        /* Chart container */
        #performanceChart {
            width: 100%;
            height: 500px;
        }
        
        /* Controls styling */
        .chart-controls {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .chart-controls select {
            flex: 1;
            min-width: 200px;
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            border-radius: 5px;
        }
        
        /* Button styling */
        .btn-primary {
            background-color: #4e79a7;
            border-color: #4e79a7;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .chart-controls {
                flex-direction: column;
                gap: 10px;
            }
            
            .chart-controls select {
                width: 100%;
            }
            
            #performanceChart {
                height: 400px;
            }
        }
    </style>
</head>
<body>
<div class="pcoded-content">
    <div class="container-fluid">
        <div class="page-header card mb-4">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="feather icon-home bg-c-blue"></i>
                        <div class="d-inline">
                            <h5><?= $title ?></h5>
                            <span><?= $title_des ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <a href="<?= base_url() ?>" class="btn btn-danger float-end">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card unit-performance-card">
                                    <div class="card-header">
                                        <h5>Performa Alat (On/Off) per Unit</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-controls">
                                           <select id="month-select">
                                             <option value="mei">Mei</option>
                                             <option value="juni">Juni</option>
                                             <option value="juli">Juli</option>
                                            
                                          </select>
                                          <select id="unit-select">
                                             <option value="14">NVA</option>
                                             <option value="15">SVA</option>
                                             <option value="16">EU</option>
                                             <option value="17">UPS</option>
                                             
                                          </select>
                                          
                                          <button id="filter-button"class="btn btn-primary float-end">Filter</button>
                                        </div>
                                        <div id="performanceChart" class="chart-container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    <script src="<?= base_url('assets_v2/baru/bootstrap-5.3.7/bootstrap.bundle.min.js') ?>"></script>
    
    <script>
// Data from controller
const performanceData = <?= json_encode($performance_data) ?>;

// Unit links configuration
const unitLinks = {
    '14': 'https://docs.google.com/spreadsheets/d/1PMTUXiciv-krJvr7yXKhCWtUZtP2ggPdvC3q-G99--k/edit',
    '15': 'https://docs.google.com/spreadsheets/d/1cKv83gBqKGp2h16HU44S3bonhNhaW6Eask9YdWz_z3A/edit?gid=455270711#gid=455270711',
    '16': 'https://docs.google.com/spreadsheets/d/1jVJ1eWt7ZIxruHQ9D5lmT6vDrL0q9zaP8BOhJNWtdas/edit?gid=10689637#gid=10689637',
    '17': 'https://docs.google.com/spreadsheets/d/1ungA0rkbEUFOWbu4-XcxtORWtPkWJk4f3ca_PuA8AhU/edit?gid=1013988609#gid=1013988609'
};

// Initialize chart
function initPerformanceChart() {
    const chartDom = document.getElementById('performanceChart');
    const myChart = echarts.init(chartDom);
    
    // Create container for unit links
    const linkContainer = document.createElement('div');
    linkContainer.id = 'unitLinks';
    linkContainer.style.textAlign = 'center';
    linkContainer.style.marginTop = '20px';
    linkContainer.style.display = 'flex';
    linkContainer.style.flexWrap = 'wrap';
    linkContainer.style.justifyContent = 'center';
    linkContainer.style.gap = '10px';
    chartDom.parentNode.insertBefore(linkContainer, chartDom.nextSibling);
    
    // Function to update chart based on selections
    function updateChart(month, unitId) {
        let seriesData = [];
        let selectedUnit = null;
        
        if (month === 'all' && unitId === 'all') {
            // Show all units across all months
            Object.entries(performanceData).forEach(([monthKey, monthData]) => {
                Object.entries(monthData).forEach(([unitKey, unitData]) => {
                    seriesData.push({
                        name: unitData.name,
                        type: 'pie',
                        radius: ['40%', '60%'],
                        center: ['50%', '50%'],
                        data: [
                            { value: unitData.on || 0, name: 'On', itemStyle: { color: '#28a745' } },
                            { value: unitData.off || 0, name: 'Off', itemStyle: { color: '#dc3545' } }
                        ],
                        label: {
                            show: false
                        },
                        labelLine: {
                            show: false
                        },
                        itemStyle: {
                            borderRadius: 5,
                            borderColor: '#fff',
                            borderWidth: 2
                        }
                    });
                });
            });
        } else if (month === 'all') {
            // Show selected unit across all months
            selectedUnit = unitId;
            Object.entries(performanceData).forEach(([monthKey, monthData]) => {
                if (monthData[unitId]) {
                    const unitData = monthData[unitId];
                    seriesData.push({
                        name: unitData.name,
                        type: 'pie',
                        radius: ['50%', '70%'],
                        center: ['50%', '50%'],
                        data: [
                            { value: unitData.on || 0, name: 'On', itemStyle: { color: '#28a745' } },
                            { value: unitData.off || 0, name: 'Off', itemStyle: { color: '#dc3545' } }
                        ],
                        label: {
                            show: false
                        },
                        labelLine: {
                            show: false
                        },
                        itemStyle: {
                            borderRadius: 5,
                            borderColor: '#fff',
                            borderWidth: 2
                        }
                    });
                }
            });
        } else if (unitId === 'all') {
            // Show all units for selected month
            Object.entries(performanceData[month]).forEach(([unitKey, unitData]) => {
                seriesData.push({
                    name: unitData.name,
                    type: 'pie',
                    radius: ['40%', '60%'],
                    center: ['50%', '50%'],
                    data: [
                        { value: unitData.on || 0, name: 'On', itemStyle: { color: '#28a745' } },
                        { value: unitData.off || 0, name: 'Off', itemStyle: { color: '#dc3545' } }
                    ],
                    label: {
                        show: false
                    },
                    labelLine: {
                        show: false
                    },
                    itemStyle: {
                        borderRadius: 5,
                        borderColor: '#fff',
                        borderWidth: 2
                    }
                });
            });
        } else {
            // Show specific unit and month
            selectedUnit = unitId;
            const unitData = performanceData[month][unitId];
            seriesData.push({
                name: unitData.name,
                type: 'pie',
                radius: ['50%', '70%'],
                center: ['50%', '50%'],
                data: [
                    { value: unitData.on || 0, name: 'On', itemStyle: { color: '#28a745' } },
                    { value: unitData.off || 0, name: 'Off', itemStyle: { color: '#dc3545' } }
                ],
                label: {
                    show: false
                },
                labelLine: {
                    show: false
                },
                itemStyle: {
                    borderRadius: 5,
                    borderColor: '#fff',
                    borderWidth: 2
                }
            });
        }
        
        // Update unit links
        updateUnitLinks(selectedUnit);
        
        const option = {
            title: {
                text: unitId === 'all' ? 'Performance Semua Unit' : performanceData[month][unitId]?.name || 'Performance',
                subtext: month === 'all' ? 'Semua Bulan' : month.toUpperCase(),
                left: 'center',
                textStyle: {
                    color: '#333',
                    fontSize: 16
                }
            },
            tooltip: {
                trigger: 'item',
                formatter: '{b}: {c} ({d}%)'
            },
            legend: {
                show: false // Hide legend as requested
            },
            series: seriesData
        };
        
        myChart.setOption(option);
    }
    
    // Function to update unit links
    function updateUnitLinks(selectedUnit) {
        const linkContainer = document.getElementById('unitLinks');
        linkContainer.innerHTML = '';
        
        if (selectedUnit) {
            const unitData = Object.values(performanceData)[0][selectedUnit];
            const link = document.createElement('a');
            link.href = unitLinks[selectedUnit];
            link.textContent = `Lihat Detail ${unitData.name}`;
            link.target = '_blank';
            link.style.color = '#fff';
            link.style.backgroundColor = '#4e79a7';
            link.style.textDecoration = 'none';
            link.style.fontWeight = 'bold';
            link.style.fontSize = '14px';
            link.style.padding = '8px 16px';
            link.style.borderRadius = '4px';
            link.style.margin = '0 5px';
            link.style.display = 'inline-block';
            linkContainer.appendChild(link);
        } else {
            // Create links for all units for the selected month
            const units = Object.values(performanceData['mei']); // Get units for May
            units.forEach(unitData => {
                const link = document.createElement('a');
                link.href = unitLinks[unitData.id];
                link.textContent = unitData.name;
                link.target = '_blank';
                link.style.color = '#fff';
                link.style.backgroundColor = '#4e79a7';
                link.style.textDecoration = 'none';
                link.style.fontWeight = 'bold';
                link.style.fontSize = '14px';
                link.style.padding = '8px 16px';
                link.style.borderRadius = '4px';
                link.style.margin = '0 5px';
                link.style.display = 'inline-block';
                linkContainer.appendChild(link);
            });
        }
    }
    
    // Event listener for filter button
    document.getElementById('filter-button').addEventListener('click', function() {
        const month = document.getElementById('month-select').value;
        const unitId = document.getElementById('unit-select').value;
        updateChart(month, unitId);
    });
    
    // Initial render (show NVA unit and May month)
    updateChart('mei', '14');
    
    // Make responsive
    window.addEventListener('resize', function() {
        myChart.resize();
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initPerformanceChart();
});


    </script>
</body>
</html>