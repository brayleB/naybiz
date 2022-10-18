<template>
   <div>
  <b-modal id="modal-details" hide-header>
    <div class="d-block">
      <h1>{{ tenant_details.firstname }}</h1>
      <h3>{{ tenant_details.about }}</h3>
    </div>
  </b-modal>
</div>
</template>
<script>
export default {
  name: "viewDetails",
  props: {
    tenant_details: {
        type: Object,
    },
  }, 
}
</script>