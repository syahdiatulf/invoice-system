import { createApp } from 'vue';
import InvoiceList from './Components/InvoiceList.vue';
import InvoiceForm from './Components/InvoiceForm.vue';

const app = createApp({});

app.component('invoice-list', InvoiceList);
app.component('invoice-form', InvoiceForm);

app.mount('#invoice-list');
app.mount('#invoice-form');
