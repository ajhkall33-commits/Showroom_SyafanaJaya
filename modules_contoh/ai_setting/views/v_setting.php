<div class="row">
  <div class="col-md-12">
    <div class="card shadow-sm border-0 rounded-lg">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-white"><i class="feather icon-settings mr-2"></i> Konfigurasi AI Provider (Groq & OpenAI)</h5>
        <a href="<?= base_url('ai_chat') ?>" class="btn btn-sm btn-light rounded-pill">
          <i class="feather icon-message-square mr-1"></i> Buka Chatbot
        </a>
      </div>
      <div class="card-body p-4">
        <form id="settingForm" onsubmit="saveSettings(event)">
          
          <!-- Provider Selection -->
          <div class="form-group row">
            <label class="col-sm-3 col-form-label font-weight-bold">Active AI Provider</label>
            <div class="col-sm-9">
              <select name="ai_provider" id="ai_provider" class="form-control">
                <option value="groq" <?= (isset($settings['ai_provider']) && $settings['ai_provider'] == 'groq') ? 'selected' : '' ?>>Groq API (Super Fast Llama 3.3 / Mixtral)</option>
                <option value="cerebras" <?= (isset($settings['ai_provider']) && $settings['ai_provider'] == 'cerebras') ? 'selected' : '' ?>>Cerebras API (Llama 3.1 70B)</option>
                <option value="gemini" <?= (isset($settings['ai_provider']) && $settings['ai_provider'] == 'gemini') ? 'selected' : '' ?>>Google Gemini (Gemini 1.5 Flash)</option>
                <option value="openrouter" <?= (isset($settings['ai_provider']) && $settings['ai_provider'] == 'openrouter') ? 'selected' : '' ?>>OpenRouter API (Free Models)</option>
                <option value="openai" <?= (isset($settings['ai_provider']) && $settings['ai_provider'] == 'openai') ? 'selected' : '' ?>>OpenAI API (GPT-4o mini / GPT-4o)</option>
              </select>
              <small class="form-text text-muted">Pilih provider mana yang digunakan sebagai backend utama chatbot.</small>
            </div>
          </div>

          <hr class="my-4">

          <!-- Groq Configuration -->
          <h6 class="font-weight-bold text-primary mb-3"><i class="feather icon-cpu mr-2"></i> Pengaturan Groq API</h6>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Groq API Key</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input type="password" name="groq_api_key" id="groq_api_key" class="form-control" value="<?= isset($settings['groq_api_key']) ? htmlspecialchars($settings['groq_api_key']) : '' ?>" placeholder="gsk_...">
                <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary" onclick="toggleShowKey('groq_api_key')"><i class="feather icon-eye"></i></button>
                  <button type="button" class="btn btn-outline-info" onclick="testConnection('groq')"><i class="feather icon-zap mr-1"></i> Test Groq</button>
                </div>
              </div>
              <small class="form-text text-muted">Dapatkan API Key gratis di <a href="https://console.groq.com/keys" target="_blank">console.groq.com</a>.</small>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Groq Model</label>
            <div class="col-sm-9">
              <input type="text" name="groq_model" class="form-control" value="<?= isset($settings['groq_model']) ? htmlspecialchars($settings['groq_model']) : 'llama-3.3-70b-versatile' ?>" placeholder="llama-3.3-70b-versatile">
              <small class="form-text text-muted">Contoh: <code>llama-3.3-70b-versatile</code>, <code>llama3-70b-8192</code>, <code>mixtral-8x7b-32768</code></small>
            </div>
          </div>

          <hr class="my-4">

          <!-- OpenAI Configuration -->
          <h6 class="font-weight-bold text-success mb-3"><i class="feather icon-globe mr-2"></i> Pengaturan OpenAI API</h6>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">OpenAI API Key</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input type="password" name="openai_api_key" id="openai_api_key" class="form-control" value="<?= isset($settings['openai_api_key']) ? htmlspecialchars($settings['openai_api_key']) : '' ?>" placeholder="sk-proj-...">
                <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary" onclick="toggleShowKey('openai_api_key')"><i class="feather icon-eye"></i></button>
                  <button type="button" class="btn btn-outline-info" onclick="testConnection('openai')"><i class="feather icon-zap mr-1"></i> Test OpenAI</button>
                </div>
              </div>
              <small class="form-text text-muted">Dapatkan API Key di <a href="https://platform.openai.com/api-keys" target="_blank">platform.openai.com</a>.</small>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label">OpenAI Model</label>
            <div class="col-sm-9">
              <input type="text" name="openai_model" class="form-control" value="<?= isset($settings['openai_model']) ? htmlspecialchars($settings['openai_model']) : 'gpt-4o-mini' ?>" placeholder="gpt-4o-mini">
              <small class="form-text text-muted">Contoh: <code>gpt-4o-mini</code>, <code>gpt-4o</code>, <code>gpt-3.5-turbo</code></small>
            </div>
          </div>

          <hr class="my-4">

          <!-- Cerebras Configuration -->
          <h6 class="font-weight-bold text-danger mb-3"><i class="feather icon-zap mr-2"></i> Pengaturan Cerebras API</h6>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Cerebras API Key</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input type="password" name="cerebras_api_key" id="cerebras_api_key" class="form-control" value="<?= isset($settings['cerebras_api_key']) ? htmlspecialchars($settings['cerebras_api_key']) : '' ?>" placeholder="...">
                <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary" onclick="toggleShowKey('cerebras_api_key')"><i class="feather icon-eye"></i></button>
                  <button type="button" class="btn btn-outline-info" onclick="testConnection('cerebras')"><i class="feather icon-zap mr-1"></i> Test Cerebras</button>
                </div>
              </div>
              <small class="form-text text-muted">Dapatkan API Key di <a href="https://cloud.cerebras.ai" target="_blank">cloud.cerebras.ai</a>.</small>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Cerebras Model</label>
            <div class="col-sm-9">
              <input type="text" name="cerebras_model" class="form-control" value="<?= isset($settings['cerebras_model']) ? htmlspecialchars($settings['cerebras_model']) : 'gemma-4-31b' ?>" placeholder="gemma-4-31b">
              <small class="form-text text-muted">Contoh: <code>gemma-4-31b</code>, <code>gpt-oss-120b</code></small>
            </div>
          </div>

          <hr class="my-4">

          <!-- Gemini Configuration -->
          <h6 class="font-weight-bold text-info mb-3"><i class="feather icon-box mr-2"></i> Pengaturan Google Gemini API</h6>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Gemini API Key</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input type="password" name="gemini_api_key" id="gemini_api_key" class="form-control" value="<?= isset($settings['gemini_api_key']) ? htmlspecialchars($settings['gemini_api_key']) : '' ?>" placeholder="AIza...">
                <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary" onclick="toggleShowKey('gemini_api_key')"><i class="feather icon-eye"></i></button>
                  <button type="button" class="btn btn-outline-info" onclick="testConnection('gemini')"><i class="feather icon-zap mr-1"></i> Test Gemini</button>
                </div>
              </div>
              <small class="form-text text-muted">Dapatkan API Key di <a href="https://aistudio.google.com/app/apikey" target="_blank">aistudio.google.com</a>.</small>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Gemini Model</label>
            <div class="col-sm-9">
              <input type="text" name="gemini_model" class="form-control" value="<?= isset($settings['gemini_model']) ? htmlspecialchars($settings['gemini_model']) : 'gemini-3.5-flash' ?>" placeholder="gemini-3.5-flash">
              <small class="form-text text-muted">Contoh: <code>gemini-3.5-flash</code>, <code>gemini-2.5-pro</code></small>
            </div>
          </div>

          <hr class="my-4">

          <!-- OpenRouter Configuration -->
          <h6 class="font-weight-bold text-warning mb-3"><i class="feather icon-layers mr-2"></i> Pengaturan OpenRouter API</h6>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">OpenRouter API Key</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input type="password" name="openrouter_api_key" id="openrouter_api_key" class="form-control" value="<?= isset($settings['openrouter_api_key']) ? htmlspecialchars($settings['openrouter_api_key']) : '' ?>" placeholder="sk-or-v1-...">
                <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary" onclick="toggleShowKey('openrouter_api_key')"><i class="feather icon-eye"></i></button>
                  <button type="button" class="btn btn-outline-info" onclick="testConnection('openrouter')"><i class="feather icon-zap mr-1"></i> Test OpenRouter</button>
                </div>
              </div>
              <small class="form-text text-muted">Dapatkan API Key di <a href="https://openrouter.ai/keys" target="_blank">openrouter.ai</a>.</small>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label">OpenRouter Model</label>
            <div class="col-sm-9">
              <input type="text" name="openrouter_model" class="form-control" value="<?= isset($settings['openrouter_model']) ? htmlspecialchars($settings['openrouter_model']) : 'openrouter/free' ?>" placeholder="openrouter/free">
              <small class="form-text text-muted">Contoh: <code>openrouter/free</code>, <code>meta-llama/llama-3.1-8b-instruct:free</code></small>
            </div>
          </div>

          <hr class="my-4">

          <!-- System Prompt -->
          <h6 class="font-weight-bold text-secondary mb-3"><i class="feather icon-sliders mr-2"></i> System Prompt Instruksi Base</h6>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">System Prompt</label>
            <div class="col-sm-9">
              <textarea name="system_prompt" class="form-control" rows="5"><?= isset($settings['system_prompt']) ? htmlspecialchars($settings['system_prompt']) : 'Kamu adalah asisten AI untuk sistem MPS (Maintenance Performance System). Tugasmu adalah menjawab pertanyaan berdasarkan data yang diberikan dari database. Jawab dalam Bahasa Indonesia yang jelas dan mudah dipahami.' ?></textarea>
              <small class="form-text text-muted">Instruksi dasar yang diberikan kepada AI sebelumcontext data dimasukkan.</small>
            </div>
          </div>

          <div class="text-right mt-4">
            <button type="submit" class="btn btn-primary px-4 rounded-pill" id="btnSave">
              <i class="feather icon-save mr-1"></i> Simpan Pengaturan
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function toggleShowKey(id) {
    let el = $('#' + id);
    if (el.attr('type') === 'password') {
      el.attr('type', 'text');
    } else {
      el.attr('type', 'password');
    }
  }

  function saveSettings(e) {
    e.preventDefault();
    $('#btnSave').prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan...');

    $.ajax({
      url: '<?= base_url("ai_setting/save") ?>',
      type: 'POST',
      data: $('#settingForm').serialize(),
      dataType: 'json',
      success: function(res) {
        $('#btnSave').prop('disabled', false).html('<i class="feather icon-save mr-1"></i> Simpan Pengaturan');
        if (res.status === '200') {
          toastr.success(res.msg);
        } else {
          toastr.error(res.msg);
        }
      },
      error: function() {
        $('#btnSave').prop('disabled', false).html('<i class="feather icon-save mr-1"></i> Simpan Pengaturan');
        toastr.error('Gagal menyimpan pengaturan.');
      }
    });
  }

  function testConnection(provider) {
    let keyInput = $('#' + provider + '_api_key').val();
    let modelInput = $('input[name="' + provider + '_model"]').val();

    toastr.info('Menguji koneksi ke ' + provider.toUpperCase() + '...');

    $.ajax({
      url: '<?= base_url("ai_setting/test_connection") ?>',
      type: 'POST',
      data: {
        provider: provider,
        apiKey: keyInput,
        model: modelInput
      },
      dataType: 'json',
      success: function(res) {
        if (res.status === '200') {
          toastr.success(res.msg);
        } else {
          toastr.error(res.msg);
        }
      },
      error: function() {
        toastr.error('Terjadi kesalahan saat menguji koneksi.');
      }
    });
  }
</script>
