<template>
  <img class="img-fluid" :src="url" />
</template>

<script>
export default {
 props: ["url"],
  data() {
    return {

    };
  },
  methods: {
   getImgUrl(pet) {
      // var images = require.context("/site/images/", false);
      // return images("./" + pet);
    },
  },
}
</script>

<style>

</style>
