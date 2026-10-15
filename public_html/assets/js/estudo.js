(function () {
  var root = document.getElementById('estudo-app');
  if (!root) return;

  var questaoId = root.dataset.questaoId;
  var csrf = root.dataset.csrf || '';
  var url = root.dataset.feedbackUrl;
  var list = document.getElementById('estudo-alternativas');
  var feedback = document.getElementById('estudo-feedback');
  var proxima = document.getElementById('estudo-proxima-form');
  var answered = false;

  if (!list) return;

  list.addEventListener('change', function (e) {
    if (answered || e.target.type !== 'radio') return;
    answered = true;

    var altId = e.target.value;
    var body = new URLSearchParams();
    body.set('questao_id', questaoId);
    body.set('alternativa_id', altId);
    body.set('_csrf', csrf);

    list.querySelectorAll('input').forEach(function (inp) { inp.disabled = true; });

    fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: body.toString(),
      credentials: 'same-origin'
    })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (!data.ok) {
          feedback.hidden = false;
          feedback.className = 'estudo-feedback estudo-feedback--erro';
          feedback.textContent = data.msg || 'Erro ao verificar resposta.';
          return;
        }

        var label = list.querySelector('[data-alt-id="' + altId + '"]');
        if (label) {
          label.style.borderColor = data.acertou ? 'var(--success)' : 'var(--danger)';
          label.style.background = data.acertou ? '#ecfdf5' : '#fef2f2';
        }

        list.querySelectorAll('label').forEach(function (lb) {
          var id = lb.getAttribute('data-alt-id');
          if (String(id) !== String(altId) && lb.querySelector('strong')) {
            var letra = lb.querySelector('strong').textContent.replace(')', '');
            if (letra.trim() === data.letra_correta) {
              lb.style.borderColor = 'var(--success)';
              lb.style.background = '#ecfdf5';
            }
          }
        });

        feedback.hidden = false;
        feedback.className = 'estudo-feedback ' + (data.acertou ? 'estudo-feedback--ok' : 'estudo-feedback--fail');
        feedback.innerHTML =
          '<p><strong>' + (data.acertou ? 'Correto!' : 'Não foi dessa vez.') + '</strong></p>' +
          '<p>Resposta correta: <strong>' + data.letra_correta + ')</strong> ' + escapeHtml(data.texto_correto) + '</p>' +
          '<p><strong>Explicação:</strong> ' + escapeHtml(data.explicacao) + '</p>' +
          '<p class="form-hint">' + escapeHtml(data.referencia) + '</p>';

        if (proxima) proxima.hidden = false;
      })
      .catch(function () {
        feedback.hidden = false;
        feedback.textContent = 'Falha de conexão. Tente novamente.';
      });
  });

  function escapeHtml(s) {
    var d = document.createElement('div');
    d.textContent = s || '';
    return d.innerHTML;
  }
})();
