<template>
    <div class="p-4 sm:p-6 md:p-8 max-w-5xl">
        <button @click="$router.go(-1)"
            class="bg-vin_blanc hover:bg-gray-700 focus:bg-gray-700 text-white font-bold rounded-full cursor-pointer transform transition-all duration-200 flex items-center">
            <i class="material-symbols-outlined py-4 px-4">arrow_back</i>
        </button>
        <section class="grid grid-cols-1 md:grid-cols-2 gap- items-center relative my-4">
            <div class="mx-auto md:mx-0 p-2">
                <img :src="imageUrl(bouteille)" :alt="bouteille.nom" class="w-full h-auto">
            </div>

            <h1 class="text-xl md:text-4xl font-bold text-vin-rouge mb-4">{{ bouteille.nom }}</h1>

            <div class="p-3">
                <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-4">
                    <span class="material-symbols-outlined w-10 h-10 rounded-lg text-vin-rouge text-3xl">flag</span>
                    <p class="text-lg lg:text-xl text-gray-900 font-bold ml-2"> {{ bouteille.pays ? bouteille.pays.nom :
                        '' }}</p>
                    <div class="flex-1"></div>
                    <span
                        class="material-symbols-outlined w-10 h-10 rounded-lg text-vin-rouge text-3xl">monetization_on</span>
                    <p class="text-lg lg:text-xl text-gray-900 font-bold ml-2 flex-grow-0 w-20"> {{ bouteille.prix ?
                        bouteille.prix + ' $' : '' }} </p>
                </div>

                <div class="flex justify-between items-center mt-4">
                    <span class="material-symbols-outlined w-10 h-10 rounded-lg text-vin-rouge text-3xl">category</span>
                    <p class="text-lg lg:text-xl text-gray-900 font-bold ml-2">{{ bouteille.categorie ?
                        bouteille.categorie.nom : '' }}</p>
                    <div class="flex-1"></div>
                    <span class="material-symbols-outlined w-10 h-10 rounded-lg text-vin-rouge text-3xl">local_bar</span>
                    <p class="text-lg lg:text-xl text-gray-900 font-bold ml-2 flex-grow-0 w-20">{{ bouteille.volume || 'N/D'
                    }}</p>
                </div>
            </div>
        </section>

        <AvisBouteilleComponent :bouteilleId="bouteille.id" v-if="bouteille.id" />
    </div>
</template>

<script>
import BouteilleDataService from "@/services/BouteilleDataService.js";
import AvisBouteilleComponent from "@/components/AvisBouteilleComponent.vue";

export default {
    components: {
        AvisBouteilleComponent,
    },
    name: "BouteilleDetailsView",
    props: {
        id: {
            type: Number,
            required: true,
        },
    },
    data () {
        return {
            bouteille: [],
        };
    },
    mounted () {
        //Appeler une méthode pour récupérer les détails de la bouteille en utilisant la propriété id.
        this.fetchBouteille(this.id);
    },
    methods: {

        async fetchBouteille (id) {
            try {
                const response = await BouteilleDataService.get(id);

                this.bouteille = this.bouteille = response.data.bouteille;;
                const regex = /(\d+)\s*(ml|L)/i;;
                const match = this.bouteille.description.match(regex); // execute la recherche dans la description
                if (match) {
                    this.bouteille.volume = match[0]; // récupère le premier groupe de capture

                }

            } catch (error) {
                    if (error.response && error.response.status === 404) {
                    // Rediriger vers la page "celliers"
                        this.$router.push({
                            name: "mes-celliers",
                        })
                }

            }
        },
        imageUrl(bouteille) {
            const baseUrl = import.meta.env.VITE_BASE_URL || "";
            if (
                bouteille.photo !==
                    "https://www.saq.com/media/catalog/product/1/4/14064101-1_1578550524.png?quality=80&fit=bounds&height=166&width=111&canvas=111:166" &&
                bouteille.code_saq === null
            ) {
                return `${baseUrl}${bouteille.photo}`;
            } else {
                return bouteille.photo;
            }
        },


    },
};
</script>
