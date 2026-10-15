(function () {
  var root = document.getElementById('simulado-app');
  if (!root) return;

  var tentativaId = root.dataset.tentativaId;
  var token = root.dataset.token;
  var duracao = parseInt(root.dataset.duracao, 10) || 0;
  var saveUrl = root.dataset.saveUrl;
  var finalizarUrl = root.dataset.finalizarUrl;

  var questoes = root.querySelectorAll('[data-questao]');
  var total = questoes.length;
  var atual = 0;
  var tempoRestante = duracao;
  var timerEl = document.getElementById('sim-timer');
  var progressEl = document.getElementById('sim-progress');
  var labelEl = document.getElementById('sim-progress-label');
  var intervalId = null;

  function mostrar(index) {
    if (index < 0 || index >= total) return;
    questoes[atual].hidden = true;
    atual = index;
    questoes[atual].hidden = false;
    if (labelEl) labelEl.textContent = 'Questão ' + (atual + 1) + ' de ' + total;
    if (progressEl) progressEl.style.width = (((atual + 1) / total) * 100) + '%';
  }

  function formatTime(s) {
    var m = Math.floor(s / 60);
    var sec = s % 60;
    return String(m).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
  }

  function tick() {
    if (tempoRestante <= 0) {
      clearInterval(intervalId);
      finalizar(true);
      return;
    }
    tempoRestante--;
    if (timerEl) {
      timerEl.textContent = formatTime(tempoRestante);
      if (tempoRestante <= 60) timerEl.classList.add('is-low');
    }
  }

  function salvar(questaoEl) {
    var qid = questaoEl.dataset.questaoId;
    var selected = questaoEl.querySelector('input[name="alt_' + qid + '"]:checked');
    var altId = selected ? selected.value : '';
    var revisao = questaoEl.querySelector('[data-revisao]');
    var rev = revisao && revisao.checked ? '1' : '0';

    var body = new URLSearchParams();
    body.set('tentativa_id', tentativaId);
    body.set('questao_id', qid);
    body.set('alternativa_id', altId);
    body.set('revisao', rev);
    body.set('token', token);
    body.set('_csrf', root.dataset.csrf || '');

    return fetch(saveUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: body.toString(),
      credentials: 'same-origin'
    });
  }

  questoes.forEach(function (qEl) {
    qEl.querySelectorAll('input[type="radio"]').forEach(function (radio) {
      radio.addEventListener('change', function () { salvar(qEl); });
    });
    var rev = qEl.querySelector('[data-revisao]');
    if (rev) rev.addEventListener('change', function () { salvar(qEl); });
  });

  root.querySelector('[data-prev]')?.addEventListener('click', function () {
    salvar(questoes[atual]).then(function () { mostrar(atual - 1); });
  });
  root.querySelector('[data-next]')?.addEventListener('click', function () {
    salvar(questoes[atual]).then(function () { mostrar(atual + 1); });
  });

  function finalizar(auto) {
    if (!auto && !window.confirm('Encerrar a prova? Você não poderá alterar as respostas.')) {
      return;
    }
    salvar(questoes[atual]).finally(function () {
      var form = document.getElementById('form-finalizar');
      if (form) {
        var tempoInput = form.querySelector('[name="tempo_utilizado"]');
        if (tempoInput) tempoInput.value = String(duracao - tempoRestante);
        if (auto) {
          var exp = form.querySelector('[name="expirado"]');
          if (exp) exp.value = '1';
        }
        form.submit();
      }
    });
  }

  root.querySelector('[data-finalizar]')?.addEventListener('click', function () { finalizar(false); });

  if (timerEl) timerEl.textContent = formatTime(tempoRestante);
  mostrar(0);
  if (duracao > 0) intervalId = setInterval(tick, 1000);
})();
