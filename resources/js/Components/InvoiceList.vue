<template>
  <div>
    <h2 class="text-xl font-bold mb-4">Invoices</h2>
    <table class="border w-full">
      <thead>
        <tr class="bg-gray-200">
          <th class="border p-2">ID</th>
          <th class="border p-2">Customer</th>
          <th class="border p-2">Date</th>
          <th class="border p-2">Total</th>
          <th class="border p-2">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="invoice in invoices" :key="invoice.id">
          <td class="border p-2">{{ invoice.id }}</td>
          <td class="border p-2">{{ invoice.customer.name }}</td>
          <td class="border p-2">{{ invoice.invoice_date }}</td>
          <td class="border p-2">{{ invoice.total }}</td>
          <td class="border p-2">
            <a :href="`/invoices/${invoice.id}`" class="text-blue-500">View</a>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Simple pagination -->
    <div class="mt-4 flex gap-2">
      <button
        v-for="page in lastPage"
        :key="page"
        @click="goToPage(page)"
        :class="page === currentPage ? 'bg-blue-500 text-white px-2 py-1 rounded' : 'bg-gray-200 px-2 py-1 rounded'">
        {{ page }}
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'InvoiceList',
  data() {
    return {
      invoices: [],
      currentPage: 1,
      lastPage: 1,
    }
  },
  mounted() {
    this.fetchInvoices();
  },
  methods: {
    fetchInvoices(page = 1) {
      axios.get(`/api/invoices?page=${page}`)
        .then(res => {
          this.invoices = res.data.data;
          this.currentPage = res.data.current_page;
          this.lastPage = res.data.last_page;
        })
        .catch(err => {
          console.error('Error fetching invoices', err);
        });
    },
    goToPage(page) {
      this.fetchInvoices(page);
    }
  }
}
</script>
