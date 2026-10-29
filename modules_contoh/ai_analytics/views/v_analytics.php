<div class="row">
  <!-- Stat Card: Total Request -->
  <div class="col-md-3">
    <div class="card shadow-sm border-0 rounded-lg bg-primary text-white">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-white-50 text-uppercase font-weight-bold mb-1" style="font-size: 11px;">Total Requests</h6>
            <h3 class="font-weight-bold text-white mb-0"><?= number_format($stats['total_requests']) ?></h3>
          </div>
          <i class="feather icon-message-circle fa-2x opacity-50"></i>
        </div>
        <div class="mt-3 text-white-50 small">
          Hari ini: <strong><?= number_format($stats['today_requests']) ?></strong> req
        </div>
      </div>
    </div>
  </div>

  <!-- Stat Card: Input Tokens -->
  <div class="col-md-3">
    <div class="card shadow-sm border-0 rounded-lg bg-info text-white">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-white-50 text-uppercase font-weight-bold mb-1" style="font-size: 11px;">Input Tokens</h6>
            <h3 class="font-weight-bold text-white mb-0"><?= number_format($stats['total_input']) ?></h3>
          </div>
          <i class="feather icon-arrow-down-left fa-2x opacity-50"></i>
        </div>
        <div class="mt-3 text-white-50 small">
          Token pertanyaan/context
        </div>
      </div>
    </div>
  </div>

  <!-- Stat Card: Output Tokens -->
  <div class="col-md-3">
    <div class="card shadow-sm border-0 rounded-lg bg-success text-white">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-white-50 text-uppercase font-weight-bold mb-1" style="font-size: 11px;">Output Tokens</h6>
            <h3 class="font-weight-bold text-white mb-0"><?= number_format($stats['total_output']) ?></h3>
          </div>
          <i class="feather icon-arrow-up-right fa-2x opacity-50"></i>
        </div>
        <div class="mt-3 text-white-50 small">
          Token jawaban AI
        </div>
      </div>
    </div>
  </div>

  <!-- Stat Card: Total Tokens -->
  <div class="col-md-3">
    <div class="card shadow-sm border-0 rounded-lg bg-warning text-dark">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-dark-50 text-uppercase font-weight-bold mb-1" style="font-size: 11px;">Total Tokens Used</h6>
            <h3 class="font-weight-bold text-dark mb-0"><?= number_format($stats['total_tokens']) ?></h3>
          </div>
          <i class="feather icon-zap fa-2x opacity-50"></i>
        </div>
        <div class="mt-3 text-dark-50 small">
          Akumulasi keseluruhan
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4">
  <!-- Chart Daily Usage -->
  <div class="col-md-8">
    <div class="card shadow-sm border-0 rounded-lg">
      <div class="card-header bg-white font-weight-bold">
        <i class="feather icon-trending-up mr-2 text-primary"></i> Tren Penggunaan 7 Hari Terakhir
      </div>
      <div class="card-body">
        <div id="usageChart" style="height: 300px; width: 100%;"></div>
      </div>
    </div>
  </div>

  <!-- Provider Breakdown -->
  <div class="col-md-4">
    <div class="card shadow-sm border-0 rounded-lg">
      <div class="card-header bg-white font-weight-bold">
        <i class="feather icon-pie-chart mr-2 text-info"></i> Provider Breakdown
      </div>
      <div class="card-body">
        <?php if (!empty($providers)): ?>
          <ul class="list-group list-group-flush">
            <?php foreach ($providers as $p): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                <div>
                  <h6 class="mb-0 font-weight-bold text-uppercase"><?= htmlspecialchars($p['provider']) ?></h6>
                  <small class="text-muted"><?= number_format($p['total_requests']) ?> requests</small>
                </div>
                <span class="badge badge-primary badge-pill px-3 py-2" style="font-size: 12px;"><?= number_format($p['total_tokens']) ?> tokens</span>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <div class="text-center p-3 text-muted">Belum ada data penggunaan provider.</div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Table Usage Logs -->
<div class="row mt-4">
  <div class="col-md-12">
    <div class="card shadow-sm border-0 rounded-lg">
      <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
        <span><i class="feather icon-list mr-2 text-secondary"></i> Log Aktivitas Penggunaan AI (20 Terbaru)</span>
        <a href="<?= base_url('ai_chat') ?>" class="btn btn-sm btn-primary rounded-pill"><i class="feather icon-message-square mr-1"></i> Buka Chatbot</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover table-striped mb-0">
            <thead class="bg-light">
              <tr>
                <th>#</th>
                <th>Waktu</th>
                <th>User</th>
                <th>Provider</th>
                <th>Model</th>
                <th>Input Token</th>
                <th>Output Token</th>
                <th>Total Token</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($logs)): ?>
                <?php foreach ($logs as $idx => $l): ?>
                  <tr>
                    <td><?= $idx + 1 ?></td>
                    <td><?= date('d/m/Y H:i:s', strtotime($l['created_at'])) ?></td>
                    <td><?= htmlspecialchars($l['user_name'] ? $l['user_name'] : 'User #' . $l['user_id']) ?></td>
                    <td><span class="badge badge-info text-uppercase"><?= htmlspecialchars($l['provider']) ?></span></td>
                    <td><code><?= htmlspecialchars($l['model']) ?></code></td>
                    <td><?= number_format($l['input_tokens']) ?></td>
                    <td><?= number_format($l['output_tokens']) ?></td>
                    <td><strong><?= number_format($l['total_tokens']) ?></strong></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="8" class="text-center p-4 text-muted">Belum ada riwayat penggunaan token.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    if (typeof echarts !== 'undefined') {
      var chartDom = document.getElementById('usageChart');
      var myChart = echarts.init(chartDom);
      
      var dates = [];
      var requests = [];
      var tokens = [];

      <?php foreach ($trend as $t): ?>
        dates.push('<?= $t['date_label'] ?>');
        requests.push(<?= (int)$t['req_count'] ?>);
        tokens.push(<?= (int)$t['token_sum'] ?>);
      <?php endforeach; ?>

      var option = {
        tooltip: {
          trigger: 'axis'
        },
        legend: {
          data: ['Total Requests', 'Total Tokens']
        },
        xAxis: {
          type: 'category',
          data: dates.length > 0 ? dates : ['No Data']
        },
        yAxis: [
          { type: 'value', name: 'Requests' },
          { type: 'value', name: 'Tokens' }
        ],
        series: [
          {
            name: 'Total Requests',
            type: 'bar',
            data: requests.length > 0 ? requests : [0],
            itemStyle: { color: '#2563eb' }
          },
          {
            name: 'Total Tokens',
            type: 'line',
            yAxisIndex: 1,
            data: tokens.length > 0 ? tokens : [0],
            itemStyle: { color: '#f59e0b' }
          }
        ]
      };

      myChart.setOption(option);
    }
  });
</script>
