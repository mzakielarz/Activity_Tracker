<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, Link, router } from "@inertiajs/vue3";

defineProps({
    categories: Array,
});

const form = useForm({
    name: "",
});
</script>

<template>
    <Head title="Category" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Kategorie
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gray-100 text-gray-900 rounded-lg">
                        <form
                            @submit.prevent="
                                // to było okey, preserveState dodałem żeby po wysłaniu formularza go resetować(tzn że input jest znowu pusty po wysłaniu)
                                form.post('/category', { preserveState: false })
                            "
                            class="flex items-center space-x-4"
                        >
                            <input
                                v-model="form.name"
                                type="text"
                                placeholder="Wpisz nazwę kategorii"
                                required
                                class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                            />
                            <button
                                type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg"
                            >
                                Dodaj kategorię
                            </button>
                        </form>
                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-8"
                        >
                            <div
                                v-for="category in categories"
                                :key="category.id"
                                class="p-4 border border-black rounded-lg hover:bg-gray-200 flex items-center justify-between"
                            >
                                <!-- Jeżeli chcemy mieć link z jakąś akcją powiązaną z backendem(tak jak w tym przypadku - przejście na inny widok) należy korzystać z komponentu <Link> z inertii + zwracaj uwagę na konsole w przeglądarce(devtools - f12 na chromie) bo wcześniej tu był router-link(gdyby to była apka w samym Vue to wtedy z niego by się korzystało), tylko nigdzie nie był importowany i w konsoli był ładny warning że to ni chuja nie zadziała -->
                                <!-- na przyszłość -  w href'ie można korzystać z faktu że route'y można nazywać, czyli jeżeli w web.php jest np ->name('category.show') to tutaj można :href="route('category.show')" - paradoksalnie łatwiej się sie w tym połapać jak się trzyma konwencji nazewnicta tych metod -->
                                <Link
                                    :href="`/categories/${category.id}`"
                                    class="text-lg font-semibold text-blue-600 hover:underline"
                                >
                                    {{ category.name }}
                                </Link>

                                <!-- Podejście laravelove, jak słusznie pamiętasz u jaromira to się tak robiło -->
                                <!-- <form
                                    @submit.prevent="
                                        form.delete('/category/{id}') - nie działa bo nie przekazujesz id, próbujesz odwołać się dosłownie pod adres '/category/{id}'
                                    "
                                >
                                    <input
                                        type="hidden"
                                        name="_method"
                                        value="DELETE"
                                    />
                                    <button
                                        type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                    >
                                        Usuń
                                    </button>
                                </form> -->
                                <!-- z inertią wygląda to tak, że nie trzeba żadnego dodatkowego formularza -->

                                <button
                                    class="mt-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg"
                                    @click="
                                        // router pozwala na manualne nawigowanie między routami, poniższy kod można czytać jak - manualnie chcę usunąć(delete) jakiś zasób wykorzystując logikę zawartą w 'category.destroy', z racji na to że 'category.destroy' przyjmuje id, to musimy to id przekazać
                                        router.delete(
                                            route('category.destroy', {
                                                id: category.id,
                                            })
                                        )

                                        // krótsza wersja usunięcia kategorii - odkomentuj to tutaj, w kontrolezre i web.php i zakumentuj obecną wersje, działać będzie tak samo a jest krótsze, może zostać obecna wersja, pokazuję to dla nauki że można robić rzeczy krócej/prościej
                                        // router.delete(
                                        //     route('category.destroy', {
                                        //         category,
                                        //     })
                                        // );
                                    "
                                >
                                    Usuń
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-8 flex flex-col items-center">
            <h3 class="text-xl font-semibold text-gray-800">
                Statystyki kategorii:
            </h3>
            <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-7xl mt-4 px-4"
            >
                <div
                    v-for="category in categories"
                    :key="category.id"
                    class="w-full p-6 border rounded-lg bg-white shadow-lg"
                >
                    <h4 class="text-lg font-semibold text-gray-800">
                        {{ category.name }}
                    </h4>
                    <p class="mt-2 text-gray-600">Ilość aktywności: ...</p>
                    <p class="text-gray-600">Średni czas trwania: ...</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
