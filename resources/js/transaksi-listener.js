import Echo from 'laravel-echo';

const echo = new Echo({
  broadcaster: 'socket.io',
  host: window.location.hostname + ':6001', 
});

echo.channel('transactions').listen('transaction-updated', (event) => {
  // Handle pembaruan status transaksi di sini
  console.log('Transaction updated:', event);
});