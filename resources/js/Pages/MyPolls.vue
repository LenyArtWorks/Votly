<script setup>
    import Header from './Header.vue';
    import { router } from '@inertiajs/vue3';

    const props = defineProps({
        polls: Object,
        votes: Object,
        userLogin: String
    });

    const polls = props.polls;

    const votes = props.votes;

    const userLogin = props.userLogin;

    function vote(optionId) {
        router.post('/polls/vote', {
            'optionId': optionId
        });
    }

    function deletePoll(pollId) {
        router.post('/polls/delete', {
            'pollId': pollId
        });

        polls.value.splice(polls.value.indexOf(polls.value.find(poll => pollId == poll.id)), 1);
    }
</script>

<template>
    <title>Мои опросы</title>
    <Header>
        <li>
            <a @click="router.get('/')" class="cursor-pointer hover:underline">
                Главная
            </a>
        </li>
        <li>
            <a @click="router.get('/polls')" class="cursor-pointer hover:underline">
                Все опросы
            </a>
        </li>
        <li>
            <a @click="router.get('/create-poll')" class="cursor-pointer hover:underline">
                Создать опрос
            </a>
        </li>
    </Header>
    <ul v-if="polls.value && polls.value.length" class="flex flex-wrap min-[1375px]:justify-between mx-auto mt-[50px] w-[75%]
        max-[1374px]:w-[75%] pb-[3%] max-[1375px]:justify-center gap-[3%] min-[1500px]:w-[70%]">
        <li v-for="poll in polls.value" :key="poll.id" class="mt-[5%]">
            <div class="flex flex-wrap justify-between w-[500px] p-[20px_30px] bg-[#057DCD] rounded-[20px] text-white">
                <button @click="deletePoll(poll.id)" class="font-bold cursor-pointer text-red-500 text-[20px] w-[100%] h-fit
                    bg-none border-none block text-right">
                    X
                </button>
                <p class="w-full mt-[20px] mb-[40px] text-center text-[23px]">
                    {{ poll.title }}
                </p>
                <ul class="flex flex-col w-[445px] mb-[50px] list-none gap-8">
                    <li v-for="option in poll.options" class="flex justify-between h-auto text-[17px] mb-[10px]">
                        <p class="flex h-auto gap-[10px] w-[390px]">
                            <input v-if="poll.status=='Завершён'" type="radio" :name="`option-for-poll${poll.id}`"
                                class="w-[20px] h-[20px]" disabled />
                            <input v-else-if="votes.value && votes.value.find(vote => vote['option_id'] == option.id)"
                                type="radio" :name="`option-for-poll${poll.id}`" class="w-[20px] h-[20px]" checked />
                            <input v-else @click="vote(option.id)" type="radio" :name="`option-for-poll${poll.id}`"
                                class="w-[20px] h-[20px]" />
                            {{ option.text }}
                        </p>
                    </li>
                </ul>
                <a class="text-white no-underline cursor-pointer">
                    {{ userLogin }}
                </a>
                <p class="poll-status">
                    {{ poll.status }}
                </p>
            </div>
        </li>
    </ul>
    <div v-else class="text-white text-center mt-[300px]">
        У вас пока что нет опросов
    </div>
</template>
