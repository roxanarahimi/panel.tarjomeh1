<template>
  <div class="m-0 p-0 parallax" >

  </div>
</template>

<script>
export default {
props: ['imageUrl'],
}
</script>

<style>
.parallax{
  width: 100%;
  height: 400px !important;
background: url('/images/bg.jpg')   top center fixed;

background-size: cover;
}
</style>
