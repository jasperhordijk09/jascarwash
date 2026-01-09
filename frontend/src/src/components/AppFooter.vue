<template>
  <v-footer
    app
    height="40"
  >
    <a
      v-for="item in items"
      :key="item.title"
      class="d-inline-block mx-2 social-link"
      :href="item.href"
      rel="noopener noreferrer"
      target="_blank"
      :title="item.title"
    >
      <v-icon
        :icon="item.icon"
      />
    </a>

    <div
      class="text-caption text-disabled"
      style="position: absolute; right: 16px;"
    >
      &copy; 2025-{{ (new Date()).getFullYear() }} <span class="d-none d-sm-inline-block">jascarwash</span>
    </div>
  </v-footer>
</template>

<script setup lang="ts">
  const items = [
    {
      title: 'Jascarwash phone',
      icon: 'mdi-phone-outline',
      href: 'tel:+31621307454',
    },
    {
      title: 'Jascarwash whatsapp',
      icon: 'mdi-whatsapp',
      href: 'https://wa.me/31621307454',
    },
    {
      title: 'Jascarwash email',
      icon: `mdi-email`,
      href: 'mailto:jascarwash@hordijk.nu',
    },
    {
      title: 'Jascarwash location',
      icon: 'mdi-map-marker',
      href: 'https://maps.app.goo.gl/bfuuzYaTBdjvpJdW6',
    }  ]
</script>

<style scoped lang="sass">
  .social-link :deep(.v-icon)
    color: rgba(var(--v-theme-on-background), var(--v-disabled-opacity))
    text-decoration: none
    transition: .2s ease-in-out

    &:hover
      color: rgba(25, 118, 210, 1)
</style>
