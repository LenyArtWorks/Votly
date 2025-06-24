<script setup>
    import { useForm } from '@inertiajs/vue3';
    import { router } from '@inertiajs/vue3';

    const form = useForm({
        login: null,
        email: null,
        password: null,
        password_confirmation: null
    });
</script>

<template>
    <title>Регистрация</title>
  <div class="bg-[#43B0F1] min-h-screen">
    <a @click="router.get('/')" class="flex items-center justify-center text-white p-5 font-['Coiny'] text-[23px] no-underline">
      <img src="../../images/LogoWhite.png" alt="Votly Logo" class="w-10 h-10 mr-1">
      Votly
    </a>
    <form @submit.prevent="form.post('/auth/register')" class="mx-auto mb-2 w-fit flex flex-col gap-2 justify-center
    flex-wrap px-15 pt-5 pb-3 bg-white rounded-[20px]">
      <p class="text-center text-[#43B0F1] text-[25px] font-bold mb-6">Регистрация</p>
      <input type="text" name="login" id="login" placeholder="Логин" v-model="form.login" class="rounded-[30px] border-none
      text-center w-[310px] p-5 font-['Comfortaa'] shadow-[2px_1px_4px_0px_rgba(0,0,0,0.3)] text-[15px]
      bg-[#EDF2FA] focus:outline-none">
      <div v-if="form.errors.login" class="text-center text-[12px] text-red-500">
        {{ form.errors.login.includes('already') ? 'Такой логин уже используется' : 'Введите логин' }}
      </div>
      <input type="password" name="password" id="password" placeholder="Пароль" v-model="form.password" class="rounded-[30px]
      border-none text-center w-[310px] p-5 font-['Comfortaa'] shadow-[2px_1px_4px_0px_rgba(0,0,0,0.3)] text-[15px]
      bg-[#EDF2FA] focus:outline-none">
      <div v-if="form.errors.password" class="text-center text-[12px] text-red-500">
        {{ form.errors.password.includes('confirmation') ? 'Пароли не совпадают' : 'Введите пароль' }}
      </div>
      <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Подтвердите пароль"
        v-model="form.password_confirmation"
        class="rounded-[30px] border-none text-center w-[310px] p-5 font-['Comfortaa']
        shadow-[2px_1px_4px_0px_rgba(0,0,0,0.3)] text-[15px] bg-[#EDF2FA] focus:outline-none">
      <input type="email" name="email" id="email" placeholder="E-mail" v-model="form.email" class="rounded-[30px] border-none
      text-center w-[310px] p-5 font-['Comfortaa'] shadow-[2px_1px_4px_0px_rgba(0,0,0,0.3)] text-[15px]
      bg-[#EDF2FA] focus:outline-none">
      <div v-if="form.errors.email" class="text-center text-[12px] text-red-500">
        {{ form.errors.email.includes('already') ? 'Такой e-mail уже используется' : 'Введите e-mail' }}
      </div>
      <button type="submit" class="rounded-[30px] border-none text-center w-[310px]
      p-5 font-['Comfortaa'] shadow-[2px_1px_4px_0px_rgba(0,0,0,0.3)] text-[15px] mt-3 bg-[#057DCD] text-white cursor-pointer">
        Зарегистрироваться
      </button>
      <div class="flex items-center justify-between mt-5">
        <hr class="w-[120px]">
        <p class="text-black text-[15px] m-0 font-light">Или</p>
        <hr class="w-[120px]">
      </div>
      <a href="/auth/google" class="flex justify-center mt-2.5">
        <img src="../../images/google-icon-logo.svg" alt="" class="w-10 h-10">
      </a>
    </form>
    <p class="text-white text-center">
      Есть аккаунт?
      <a @click="router.get('/auth/login')" class="text-white bg-none hover:underline cursor-pointer">
        Войти
      </a><br>
      <a @click="router.get('/')" class="text-white bg-none hover:underline">
        Войти как гость
      </a>
    </p>
  </div>
</template>
