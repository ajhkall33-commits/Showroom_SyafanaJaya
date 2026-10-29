<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<style>
  .chat-card {
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    background: #ffffff;
    border: none;
    overflow: hidden;
    height: calc(100vh - 140px);
    min-height: 550px;
    display: flex;
  }
  .chat-sidebar {
    width: 280px;
    background: #f8fafc;
    border-right: 1px solid #e2e8f0;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
  }
  .chat-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #ffffff;
    position: relative;
  }
  .chat-header {
    padding: 16px 24px;
    background: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .chat-messages {
    flex: 1;
    padding: 24px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
  }
  .chat-input-area {
    padding: 16px 24px;
    background: #ffffff;
    border-top: 1px solid #e2e8f0;
  }
  .msg-bubble {
    max-width: 80%;
    padding: 14px 18px;
    border-radius: 18px;
    font-size: 14px;
    line-height: 1.6;
    word-break: break-word;
    box-shadow: 0 2px 5px rgba(0,0,0,0.03);
    overflow-x: auto;
    flex-shrink: 0;
  }
  .msg-user {
    align-self: flex-end;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #ffffff;
    border-bottom-right-radius: 4px;
  }
  .msg-assistant {
    align-self: flex-start;
    background: #f1f5f9;
    color: #1e293b;
    border-bottom-left-radius: 4px;
    border: 1px solid #e2e8f0;
    max-width: 98%;
  }
  .msg-assistant table {
    width: 100%;
    margin: 10px 0;
    border-collapse: collapse;
    font-size: 12px;
  }
  .msg-assistant th, .msg-assistant td {
    border: 1px solid #cbd5e1;
    padding: 6px 10px;
    text-align: left;
  }
  .msg-assistant th {
    background-color: #e2e8f0;
  }
  .conv-item {
    padding: 12px 16px;
    border-radius: 10px;
    margin: 4px 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
    color: #475569;
    transition: background 0.2s;
  }
  .conv-item:hover, .conv-item.active {
    background: #e2e8f0;
    color: #0f172a;
    font-weight: 600;
  }
  .typing-indicator {
    align-self: flex-start;
    background: #f1f5f9;
    padding: 12px 18px;
    border-radius: 18px;
    font-size: 13px;
    color: #64748b;
  }
  .dot-pulse {
    display: inline-block;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background-color: #64748b;
    animation: pulse 1.2s infinite ease-in-out;
  }
  .dot-pulse:nth-child(2) { animation-delay: 0.2s; }
  .dot-pulse:nth-child(3) { animation-delay: 0.4s; }
  @keyframes pulse {
    0%, 80%, 100% { transform: scale(0); opacity: 0.3; }
    40% { transform: scale(1); opacity: 1; }
  }
  .sample-badge {
    cursor: pointer;
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
    border-radius: 20px;
    padding: 6px 14px;
    font-size: 12px;
    transition: all 0.2s;
    display: inline-block;
    margin: 4px 2px;
  }
  .sample-badge:hover {
    background: #dbeafe;
    transform: translateY(-1px);
  }
  .chat-sidebar.hide-desktop {
    display: none !important;
  }
  @media (max-width: 768px) {
    .chat-sidebar {
      position: absolute;
      left: -280px;
      top: 0;
      bottom: 0;
      z-index: 100;
      box-shadow: 4px 0 15px rgba(0,0,0,0.1);
    }
    .chat-sidebar.show {
      left: 0;
    }
    .msg-bubble {
      max-width: 98%;
    }
  }
</style>

<div class="container-fluid p-0">
  <div class="chat-card">
    
    <!-- Sidebar Riwayat Conversation -->
    <div class="chat-sidebar" id="chatSidebar">
      <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
        <h6 class="mb-0 font-weight-bold text-primary"><i class="feather icon-message-square mr-2"></i> Percakapan</h6>
        <div>
          <button class="btn btn-sm btn-light rounded-circle d-md-none mr-1" onclick="toggleSidebar()">
            <i class="fa fa-times"></i>
          </button>
          <button class="btn btn-sm btn-primary rounded-circle" onclick="startNewChat()" data-toggle="tooltip" title="Percakapan Baru">
            <i class="feather icon-plus"></i>
          </button>
        </div>
      </div>

      <div class="flex-1 overflow-auto py-2" id="conversationList">
        <?php if (!empty($conversations)): ?>
          <?php foreach ($conversations as $c): ?>
            <div class="conv-item" id="conv-<?= $c['id'] ?>" onclick="loadConversation(<?= $c['id'] ?>)">
              <span class="text-truncate"><i class="feather icon-message-circle mr-1"></i> <?= htmlspecialchars($c['title']) ?></span>
              <i class="feather icon-trash-2 text-danger ml-2" onclick="deleteConversation(event, <?= $c['id'] ?>)"></i>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="text-center p-3 text-muted small">Belum ada riwayat percakapan.</div>
        <?php endif; ?>
      </div>

      <?php if (session('type_user') === 'super' || session('type_user') == 1): ?>
      <div class="p-3 border-top bg-light">
        <a href="<?= base_url('ai_setting') ?>" class="btn btn-sm btn-outline-secondary btn-block mb-2">
          <i class="feather icon-settings mr-1"></i> AI Settings
        </a>
        <a href="<?= base_url('ai_analytics') ?>" class="btn btn-sm btn-outline-info btn-block">
          <i class="feather icon-bar-chart-2 mr-1"></i> AI Analytics
        </a>
      </div>
      <?php endif; ?>
    </div>

    <!-- Main Chat Workspace -->
    <div class="chat-main">
      <!-- Header Bar -->
      <div class="chat-header">
        <div class="d-flex align-items-center">
          <button class="btn btn-sm btn-light mr-2" onclick="toggleSidebar()" data-toggle="tooltip" title="Tampilkan/Sembunyikan Sidebar">
            <i class="feather icon-menu"></i>
          </button>
          <div>
            <h6 class="mb-0 font-weight-bold" id="chatTitle"><i class="fa fa-robot text-primary mr-2"></i> MPS AI Chatbot</h6>
            <small class="text-muted">Database Connected • Live Context Search</small>
          </div>
        </div>
        <div>
          <button class="btn btn-sm btn-light rounded-pill" onclick="startNewChat()">
            <i class="feather icon-plus mr-1"></i> Chat Baru
          </button>
        </div>
      </div>

      <!-- Messages Display -->
      <div class="chat-messages" id="chatMessages">
        <div class="msg-bubble msg-assistant">
          <strong>Halo! 👋 Saya adalah MPS AI Assistant.</strong><br>
          Saya dapat menjawab pertanyaan Anda tentang data <strong>Alat (Perangkat), Unit Kerja, Preventive Maintenance dan Corrective Maintenance, Work Order, dan Petugas</strong> secara live dari database.<br><br>
          <span class="text-muted small">Silakan ketik pertanyaan Anda atau pilih contoh pertanyaan berikut:</span>
          <div class="mt-2">
            <span class="sample-badge" onclick="useSample('Rincikan mengenai seluruh unit yang melakukan perawatan 2M, 1B, 3B, 6B, dan T')">📋 Rincian Perawatan 2M, 1B, 3B, 6B, T</span>
            <span class="sample-badge" onclick="useSample('Tampilkan daftar Peralatan dan Jenis Alat / Kategori Peralatan')">🛠️ Peralatan & Jenis Alat</span>
            <span class="sample-badge" onclick="useSample('Berapa Work Order dan Tindak Lanjut yang berstatus Approved?')">🎫 WO & Tinjut Approved</span>
            <span class="sample-badge" onclick="useSample('Tampilkan data Temuan Kerusakan dan Komponen Terpakai')">🔍 Temuan & Komponen</span>
          </div>
        </div>

      </div>

      <!-- Input Area -->
      <div class="chat-input-area">
        <form id="chatForm" onsubmit="sendMessage(event)">
          <input type="hidden" id="currentConvId" value="">
          <div class="d-flex mb-2">
            <select id="aiProviderSelect" class="form-control form-control-sm border-0 bg-light" style="width: auto; border-radius: 20px; font-size: 12px; color: #475569;">
              <option value="auto">⚡ Auto (Smart Fallback)</option>
              <option value="groq">Groq</option>
              <option value="cerebras">Cerebras</option>
              <option value="openrouter">OpenRouter</option>
              <option value="gemini">Gemini</option>
              <option value="openai">OpenAI</option>
            </select>
          </div>
          <div class="input-group">
            <textarea id="userInput" class="form-control border-0 bg-light rounded-pill px-4" rows="1" placeholder="Ketik pertanyaan Anda di sini... (Contoh: Berapa peralatan dan alat di Unit PS1?)" style="resize: none;" onkeydown="handleKeyDown(event)"></textarea>
            <div class="input-group-append ml-2">
              <button type="submit" class="btn btn-primary rounded-circle" id="btnSend">
                <i class="fa fa-paper-plane"></i>
              </button>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
  let activeConvId = null;

  function toggleSidebar() {
    if (window.innerWidth <= 768) {
      $('#chatSidebar').toggleClass('show');
    } else {
      $('#chatSidebar').toggleClass('hide-desktop');
    }
  }

  function useSample(text) {
    $('#userInput').val(text);
    sendMessage();
  }

  function handleKeyDown(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      sendMessage();
    }
  }

  function startNewChat() {
    activeConvId = null;
    $('#currentConvId').val('');
    $('.conv-item').removeClass('active');
    $('#chatTitle').html('<i class="fa fa-robot text-primary mr-2"></i> Percakapan Baru');
    if (window.innerWidth <= 768) {
      $('#chatSidebar').removeClass('show');
    }
    $('#chatMessages').html(`
      <div class="msg-bubble msg-assistant">
        <strong>Halo! 👋 Saya adalah MPS AI Assistant.</strong><br>
        Saya dapat menjawab pertanyaan Anda tentang data <strong>Alat (Perangkat), Unit Kerja, Preventive Maintenance dan Corrective Maintenance, Work Order, dan Petugas</strong> secara live dari database.<br><br>
        <span class="text-muted small">Silakan ketik pertanyaan Anda atau pilih contoh pertanyaan di bawah:</span>
        <div class="mt-2">
          <span class="sample-badge" onclick="useSample('Rincikan mengenai seluruh unit yang melakukan perawatan 2M, 1B, 3B, 6B, dan T')">📋 Rincian Perawatan 2M, 1B, 3B, 6B, T</span>
          <span class="sample-badge" onclick="useSample('Tampilkan daftar Peralatan dan Jenis Alat / Kategori Peralatan')">🛠️ Peralatan & Jenis Alat</span>
          <span class="sample-badge" onclick="useSample('Berapa Work Order dan Tindak Lanjut yang berstatus Approved?')">🎫 WO & Tinjut Approved</span>
        </div>
      </div>
    `);
  }

  function loadConversation(convId) {
    activeConvId = convId;
    $('#currentConvId').val(convId);
    $('.conv-item').removeClass('active');
    $('#conv-' + convId).addClass('active');

    if (window.innerWidth <= 768) {
      $('#chatSidebar').removeClass('show');
    }

    $('#chatMessages').html('<div class="text-center p-4 text-muted"><i class="fa fa-spinner fa-spin mr-2"></i>Memuat percakapan...</div>');

    $.ajax({
      url: '<?= base_url("ai_chat/get_messages/") ?>' + convId,
      type: 'GET',
      dataType: 'json',
      success: function(res) {
        if (res.status === '200') {
          let html = '';
          res.data.forEach(function(m) {
            let roleClass = m.role === 'user' ? 'msg-user' : 'msg-assistant';
            let formattedContent = m.role === 'user' ? escapeHtml(m.content) : marked.parse(m.content);
            html += `<div class="msg-bubble ${roleClass}">${formattedContent}</div>`;
          });
          $('#chatMessages').html(html);
          scrollToBottom();
        }
      }
    });
  }

  function sendMessage(e) {
    if (e) e.preventDefault();
    let input = $('#userInput').val().trim();
    if (!input) return;

    // Append user bubble
    $('#chatMessages').append(`<div class="msg-bubble msg-user">${escapeHtml(input)}</div>`);
    $('#userInput').val('');
    scrollToBottom();

    // Show typing indicator
    $('#typingIndicator').remove(); // Hapus yang lama jika ada
    let typingHtml = `
      <div class="typing-indicator" id="typingIndicator">
        <i class="feather icon-cpu text-primary mr-1"></i> AI sedang membaca database & menyusun jawaban... 
        <span class="dot-pulse ml-2"></span>
        <span class="dot-pulse"></span>
        <span class="dot-pulse"></span>
      </div>
    `;
    $('#chatMessages').append(typingHtml);
    scrollToBottom();
    $('#btnSend').prop('disabled', true);

    $.ajax({
      url: '<?= base_url("ai_chat/send") ?>',
      type: 'POST',
      data: {
        message: input,
        conversation_id: activeConvId,
        provider: $('#aiProviderSelect').val()
      },
      dataType: 'json',
      success: function(res) {
        $('#typingIndicator').remove();
        $('#btnSend').prop('disabled', false);

        if (res.status === '200') {
          if (!activeConvId) {
            activeConvId = res.conversation_id;
            $('#currentConvId').val(activeConvId);
            refreshConversationList();
          }

          let assistantHtml = marked.parse(res.reply);
          let tokenInfo = `<div class="mt-2 text-right opacity-75" style="font-size:10px;"><i class="feather icon-zap text-warning mr-1"></i>${res.provider} (${res.model}) • ${res.tokens} tokens</div>`;
          $('#chatMessages').append(`<div class="msg-bubble msg-assistant">${assistantHtml} ${tokenInfo}</div>`);
          scrollToBottom();
        } else {
          $('#chatMessages').append(`<div class="msg-bubble msg-assistant text-danger"><i class="feather icon-alert-triangle mr-1"></i> ${res.msg}</div>`);
          scrollToBottom();
        }
      },
      error: function() {
        $('#typingIndicator').remove();
        $('#btnSend').prop('disabled', false);
        $('#chatMessages').append(`<div class="msg-bubble msg-assistant text-danger"><i class="feather icon-alert-triangle mr-1"></i> Gagal menghubungi server. Silakan coba lagi.</div>`);
        scrollToBottom();
      }
    });
  }

  function refreshConversationList() {
    $.ajax({
      url: '<?= base_url("ai_chat/get_conversations") ?>',
      type: 'GET',
      dataType: 'json',
      success: function(res) {
        if (res.status === '200') {
          let html = '';
          res.data.forEach(function(c) {
            let active = c.id == activeConvId ? 'active' : '';
            html += `
              <div class="conv-item ${active}" id="conv-${c.id}" onclick="loadConversation(${c.id})">
                <span class="text-truncate"><i class="feather icon-message-circle mr-1"></i> ${escapeHtml(c.title)}</span>
                <i class="feather icon-trash-2 text-danger ml-2" onclick="deleteConversation(event, ${c.id})"></i>
              </div>
            `;
          });
          $('#conversationList').html(html);
        }
      }
    });
  }

  function deleteConversation(e, convId) {
    e.stopPropagation();
    if (confirm('Hapus percakapan ini?')) {
      $.ajax({
        url: '<?= base_url("ai_chat/delete_conversation/") ?>' + convId,
        type: 'POST',
        dataType: 'json',
        success: function(res) {
          if (res.status === '200') {
            $('#conv-' + convId).remove();
            if (activeConvId == convId) {
              startNewChat();
            }
          }
        }
      });
    }
  }

  function scrollToBottom() {
    let container = document.getElementById('chatMessages');
    container.scrollTop = container.scrollHeight;
  }

  function escapeHtml(text) {
    return text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }
</script>
