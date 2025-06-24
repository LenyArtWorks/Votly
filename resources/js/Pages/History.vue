<script setup>
    import { router } from '@inertiajs/vue3';
    import Header from '../Pages/Header.vue';

    const props = defineProps(
        {
            polls: Object,
            votes: Object
        });

    const votes = props.votes;
    const polls = props.polls;
</script>

<template>
    <title>История</title>
    <Header>
        <li class="leading-none"><a @click="router.get('/polls')" class="cursor-pointer hover:underline">Все опросы</a></li>
        <li class="leading-none"><a @click="router.get('/polls/create')" class="cursor-pointer hover:underline">Создать опрос</a></li>
        <li class="leading-none"><a @click="router.get('/polls/user')" class="cursor-pointer hover:underline">Мои опросы</a></li>
    </Header>
    <p class="mt-[60px] text-[30px] text-center text-white mb-20">История</p>
    <ul v-if="polls.length != 0" class="columns-auto columns-md gap-x-[30px] mt-[50px] w-[70%] mx-auto max-[1200px]:columns-1sm max-[1425px]:columns-1
    max-[1425px]:w-fit">
  <li v-for="poll in polls" :key="poll.id" class="w-[500px] mb-[50px] break-inside-avoid">
    <div class="flex flex-wrap justify-between p-[20px_30px] bg-[#057DCD] rounded-[20px] text-white">
      <a @click="router.get('poll-result', {'pollId': poll.id})" class="w-full mt-[20px] mb-[40px] text-center text-[23px] text-white cursor-pointer hover:underline">
        {{ poll.title }}
      </a>
      <ul class="flex flex-col w-full mb-[50px] list-none gap-8">
        <li v-for="option in poll.options" class="flex justify-between">
          <p class="flex items-center gap-[10px] w-[390px] text-[17px]">
            <input v-if="poll.status=='Завершён' && votes.find(vote => vote['option_id'] == option.id)"
                type="radio" class="w-[20px] h-[20px]" disabled checked />
            <input v-else-if="poll.status=='Завершён'"
                type="radio" class="w-[20px] h-[20px]" disabled checked />
            <input v-else-if="votes && votes.find(vote => vote['option_id'] == option.id)" type="radio"
            class="w-[20px] h-[20px]" checked />
            <input v-else @click="vote(option.id, option.id)" type="radio" :id="option.id" class="w-[20px] h-[20px]" />
            {{ option.text }}
          </p>
        </li>
      </ul>
      <a class="text-white no-underline cursor-pointer hover:underline">
        {{ poll.author }}
      </a>
      <p class="mb-0">
        {{ poll.status }}
      </p>
    </div>
  </li>
</ul>
    <p v-else class="text-center text-white mt-[120px]">
      Вы ещё не прошли ни одного опроса
    </p>
</template>
