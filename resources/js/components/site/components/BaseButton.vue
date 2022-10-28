<template>
<!-- :class="{
    'btn-warning text-light': type === 'warning',
    'btn-danger': type === 'danger',
    'btn-primary': type === 'primary',
    'btn-secondary': type === 'secondary',
    'btn-light': type === 'light',
    'btn-dark': type === 'dark',
    'btn-info': type === 'info',
    'btn-light': type === null,
  }" -->
  <!-- <button :style="cssVars" > -->
  <button class="btn" 
   >
    {{ title }}
  </button>
</template>

<script>
export default {
  props: ["title"],

  computed: {
    // cssVars() {
    //   return {
    //     /* variables you want to pass to css */
    //     "--color": this.bg_color ?  this.bg_color : 'dimgray',
    //   };
    // },
  },
};
</script>

<style >
/* button {
  border: 1px solid transparent;
    background-color: var(--color);
  padding: 5px 10px;
  border-radius: 3px;
  margin: 5px 10px;
  color: white;
  cursor: pointer;
  transition: 0.25s ease;
}
button:hover {
 opacity: 0.7;
} */
</style>
