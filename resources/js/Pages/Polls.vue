<script setup>
    import Header from './Header.vue'
    import { router } from '@inertiajs/vue3'
    import { ref, computed, reactive } from 'vue';

    const searchText = ref("");

    const categoriesList = [
        'Технологии',
        'Кино и сериалы',
        'Игры',
        'Еда',
        'Путешествия',
        'Спорт',
        'Мода',
        'Музыка',
        'Наука',
        'Авто',
        'Здоровье',
        'Образование',
        'Юмор',
        'Другое'
    ];

    const categories = reactive([]);

    const props = defineProps( {
        'polls': {
            'required': true,
            'type': Object
        },
        'status': String,
        'user': Object,
        'votes': Object
    });

    const status = ref(props.status);

    const votes = props.votes;

    const user = props.user;

    function vote(optionId, elId) {
        if (user.login) {
            router.post('/polls/vote', {
                'optionId': optionId
            });
        }
        else {
            alert('Чтобы проголосовать необходимо войти в аккаунт!');
            const el = document.getElementById(elId);
            el.checked = false;
        }
    }

    function search() {
        router.get(`/polls?search-text=${searchText.value}&status=${status.value}`);
    }

    const filteredPolls = computed(() => {
        return props.polls.filter((el) => {
            if (categories.length != 0) {
                return el.status.includes(status.value) && categories.indexOf(el.category) >= 0;
            }
            else {
                return el.status.includes(status.value);
            }
        });
    });

    function addCategory(categoryName) {
        const index = categories.indexOf(categoryName);

        if (index === -1) {
            categories.push(categoryName);
        }
        else {
            categories.splice(index, 1);
        }

        console.log(categories.length);
    }

    function appearSidebar() {
        const sidebar = document.getElementById('sidebar');
        const display = sidebar.style.display;
        const appearButton = document.getElementById('appear-sidebar');

        if (display == 'none') {
            appearButton.textContent = '<'
            sidebar.style.display = 'block'
        }
        else {
            appearButton.textContent = '>'
            sidebar.style.display = 'none'
        }
    }
</script>

<template>
    <title>Опросы</title>
  <div class="bg-[#43B0F1] pb-[50px]">
    <Header>
      <li><a @click="router.get('/')" class="cursor-pointer hover:underline">Главная</a></li>
      <li><a @click="router.get('/polls')" class="cursor-pointer hover:underline">Все опросы</a></li>
      <li><a @click="router.get('/polls/create')" class="cursor-pointer hover:underline">Создать опрос</a></li>
      <li><a @click="router.get('/polls/user')" class="cursor-pointer hover:underline">Мои опросы</a></li>
    </Header>
    <aside class="absolute w-fit mt-20 pt-6 px-5 bg-white rounded-r-[30px] h-fit flex flex-col text-[#43B0F1]" id="sidebar">
      <p class="text-[100%]">Статус</p>
      <ul class="flex flex-col gap-[15px] mt-[20px] mb-2 pl-[10px] mr-[10px] text-[80%]">
        <li class="flex items-center h-full text-[12px]">
          <input type="radio" name="poll-status-select" value="Активен" v-model="status" class="mr-[10px]">Активные
        </li>
        <li class="flex items-center h-full text-[12px]">
          <input type="radio" name="poll-status-select" value="Завершён" v-model="status" class="mr-[10px]">Завершённые
        </li>
        <li class="flex items-center h-full text-[12px]">
          <input type="radio" name="poll-status-select" value="" v-model="status" class="mr-[10px]">Оба варианта
        </li>
      </ul>
      <p class="text-[100%]">Категория</p>
      <ul class="flex flex-col gap-[15px] mt-[20px] mb-[30px] pl-[10px] mr-[10px] text-[80%]">
        <li v-for="category in categoriesList" :key="category" class="flex items-center h-full text-[12px]">
          <input type="checkbox" name="poll-category-select" @click="addCategory(category)" class="mr-[10px]">{{ category }}
        </li>
      </ul>
    </aside>
    <button class="w-fit h-fit text-[25px] text-white mt-8 ml-2" @click="appearSidebar" id="appear-sidebar">
        <
    </button>
    <div class="flex w-full h-[200px] justify-end py-[70px] px-[30px]">
      <form @submit.prevent="search" class="flex items-center">
        <input type="text" v-model="searchText" placeholder="Найти опрос" class="rounded-[20px] bg-white
            border-none py-[20px] px-[50px] mr-[30px] text-center text-[20px] focus:text-[#43B0F1]
            focus:outline-none placeholder-[#43B0F1] font-['Comfortaa',sans-serif]">
        <button type="submit" class="pl-5 pt-3 pb-[14px] text-white bg-[#057DCD] border-none
            rounded-[20px] hover:cursor-pointer w-17 h-17">
          <img src="../../images/icons8-лупа-100.png" alt="Search" class="w-[30px] h-[30px]">
        </button>
      </form>
    </div>
    <ul v-if="filteredPolls.length != 0" class="columns-auto columns-md gap-x-[30px] mt-[50px] w-[70%] mx-auto max-[1200px]:columns-1sm max-[1425px]:columns-1
    max-[1425px]:w-fit">
  <li v-for="poll in filteredPolls" :key="poll.id" class="w-[500px] mb-[50px] break-inside-avoid">
    <div class="flex flex-wrap justify-between p-[20px_30px] bg-[#057DCD] rounded-[20px] text-white">
      <a @click="router.get('poll-result', {'pollId': poll.id})" class="w-full mt-[20px] mb-[40px] text-center text-[23px] text-white cursor-pointer hover:underline">
        {{ poll.title }}
      </a>
      <ul class="flex flex-col w-full mb-[50px] list-none gap-8">
        <li v-for="option in poll.options" class="flex justify-between">
          <p class="flex items-center gap-[10px] w-[390px] text-[17px]">
            <input v-if="poll.status=='Завершён'" type="radio" class="w-[20px] h-[20px]" disabled />
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
      Нет опросов, соответствующих запросу
    </p>
  </div>
</template>
