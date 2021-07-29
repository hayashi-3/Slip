function calc(subtotal, sales_tax_rate) {
  const sales_tax = document.getElementById('s_tax').value = Math.round(subtotal * (sales_tax_rate / 100));
  document.getElementById('g_total').value = parseInt(subtotal) + parseInt(sales_tax);
}