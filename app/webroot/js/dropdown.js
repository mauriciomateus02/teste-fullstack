// $(document).ready(function() {
//     $('#services').select2({
//         placeholder: "Selecione...",
//         allowClear: true
//     });
// });

$(document).ready(function() {

  $('#services').select2({
    width: '63%',
    // Renderiza como ficará a "tag" selecionada (aqui podemos devolver HTML)
    templateSelection: function(data) {
      // sem id = placeholder / não é uma opção válida
      if (!data.id) return data.text;

      // pega cor definida no elemento <option data-color="...">
      var color = (data.element && $(data.element).data('color')) ? $(data.element).data('color') : '#c0392b';

      // retorna HTML customizado — você pode adicionar classes, ícone, etc.
      return `<span class="my-select-choice" style="--choice-color:${color}">
                <span class="my-choice-text">${data.text}</span>
              </span>`;
    },

    // importante: permite devolver HTML em templateSelection
    escapeMarkup: function(markup) { return markup; }
  });

});
