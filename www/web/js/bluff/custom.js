Bluff.Tooltip.show = function(name, color, data) {
  data = Number(String(data).substr(0, this.DATA_LENGTH));
  this._tip.innerHTML = '<span class="color" style="background: ' + color + ';">&nbsp;</span> ' +
                        '<span class="data">' + data + '</span>' +
                        ' <span class="label">' + name + '</span> ';
  this._tip.style.display = '';
}