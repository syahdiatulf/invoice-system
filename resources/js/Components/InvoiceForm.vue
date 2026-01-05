<template>
  <div class="p-6 border rounded shadow-md max-w-4xl mx-auto bg-white">
    <h2 class="text-2xl font-bold mb-4">Create Invoice</h2>

    <!-- Customer Dropdown -->
    <div class="mb-4">
      <label class="block mb-1 font-semibold">Customer</label>
      <select v-model="invoice.customer_id" class="border p-2 w-full">
        <option disabled value="">Select Customer</option>
        <option v-for="customer in customers" :key="customer.id" :value="customer.id">
          {{ customer.name }}
        </option>
      </select>
    </div>

    <!-- Invoice Date -->
    <div class="mb-4">
      <label class="block mb-1 font-semibold">Invoice Date</label>
      <input type="date" v-model="invoice.invoice_date" class="border p-2 w-full"/>
    </div>

    <!-- Line Items -->
    <div v-for="(item, index) in invoice.items" :key="index" class="mb-4 border p-2 rounded">
      <div class="flex flex-col md:flex-row md:gap-2 items-end">
        <div class="flex-1 mb-2 md:mb-0">
          <label class="block mb-1">Product</label>
          <input v-model="item.product_name" type="text" placeholder="Product Name" class="border p-2 w-full"/>
        </div>

        <div class="w-20 mb-2 md:mb-0">
          <label class="block mb-1">Qty</label>
          <input v-model.number="item.quantity" type="number" min="1" class="border p-2 w-full"/>
        </div>

        <div class="w-24">
          <label class="block mb-1">Price</label>
          <input v-model.number="item.price" type="number" min="0" step="0.01" class="border p-2 w-full"/>
        </div>

        <div class="ml-2">
          <button @click="removeItem(index)" class="bg-red-500 text-white px-2 py-1 rounded">X</button>
        </div>
      </div>
    </div>

    <!-- Add Item Button -->
    <div class="flex gap-2 mt-4">
      <button @click="addItem" class="bg-gray-300 px-4 py-2 rounded">Add Item</button>
    </div>

    <!-- Total Amount -->
    <div class="mt-4 text-right font-semibold text-lg">
      Total: ${{ total.toFixed(2) }}
    </div>

    <!-- Save Invoice -->
    <div class="mt-4">
      <button @click="submitInvoice" class="bg-blue-500 text-white px-4 py-2 rounded">
        Save Invoice
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      customers: [],
      invoice: {
        customer_id: '',
        invoice_date: new Date().toISOString().slice(0,10), // default today
        items: [
          { product_name: '', quantity: 1, price: 0 }
        ]
      }
    };
  },
  computed: {
    total() {
      return this.invoice.items.reduce((sum, item) => {
        return sum + (item.quantity * item.price);
      }, 0);
    }
  },
  mounted() {
  axios.get('/api/customers') 
    .then(res => {
      this.customers = res.data;
    }).catch(err => {
      console.error('Error fetching customers', err);
    });
  },
  methods: {
    addItem() {
      this.invoice.items.push({ product_name: '', quantity: 1, price: 0 });
    },
    removeItem(index) {
      this.invoice.items.splice(index, 1);
    },
    submitInvoice() {
    axios.post('/api/invoices', this.invoice)
      .then(res => {
        // Success alert
        alert('Invoice saved!');

        // Redirect to invoice list
        window.location.href = '/invoices'; // <-- go to Invoice List page
      })
      .catch(err => {
        if (err.response && err.response.data.errors) {
          console.log(err.response.data.errors);
          alert('Validation error, check console.');
        } else {
          console.error(err);
          alert('Error saving invoice.');
        }
      });
  }

  }
};
</script>
