<template>
    <div
        class="bg-bg_rose flex flex-col overflow-hidden shadow rounded-lg h-full mx-2"
        v-for="bouteille in bouteilles"
        :key="bouteille.id"
    >
        <div class="flex items-start">
            <div class="w-1/3">
                <div class="relative">
                    <div
                        class="text-center text-white font-bolder font-sans p-1"
                        :class="categorieBgColor(bouteille.categorie.nom)"
                    >
                        {{ bouteille.categorie.nom }}
                    </div>
                    <img
                        :src="imageUrl(bouteille)"
                        :alt="bouteille.nom"
                        class="w-2/3 mt-4 mb-4 mx-auto"
                    />
                </div>
            </div>

            <div class="px-4 pt-2 w-2/3 flex flex-col h-full">
                <router-link
                    :to="{
                        name: 'bouteille-details',
                        params: { id: bouteille.id },
                    }"
                >
                    <h4
                        class="font-serif text-[15px] font-semibold text-vin-rouge text-left h-[67px] leading-tight underline"
                    >
                        {{ bouteille.nom }}
                    </h4>
                </router-link>
                <div class="text-sm mt-auto">
                    <div class="flex justify-between items-center">
                        <div class="w-full font-sans text-gray-700">
                            <div class="font-medium text-left">
                                {{ bouteille.pays.nom }}
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="font-medium text-left">Qté:</div>
                                <div class="flex items-center">
                                    <button
                                        class="bg-gray-300 text-vin-rouge font-bold px-2 rounded"
                                        @click="decrementQuantite(bouteille)"
                                    >
                                        -
                                    </button>
                                    <div class="text-center px-2">
                                        {{ bouteille.pivot.quantite }}
                                    </div>
                                    <button
                                        class="bg-gray-300 text-vin-rouge font-bold px-2 rounded"
                                        @click="incrementQuantite(bouteille)"
                                    >
                                        +
                                    </button>
                                </div>

                                <!-- Notes -->
                                <div class="text-gray-700 font-medium mr-2">
                                    <div class="flex items-center">
                                        <template v-for="i in 5" :key="i">
                                            <svg
                                                :class="{
                                                    'text-vin-blanc':
                                                        bouteille.moyenneNotes >=
                                                        i,
                                                }"
                                                class="w-4 h-4 fill-current"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M12 2 L15.09 8.09 L23 9.54 L17.91 15.5 L19.64 23.54 L12 20.59 L4.36 23.54 L6.09 15.5 L1 9.54 L8.91 8.09 L12 2 Z"
                                                />
                                            </svg>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="pb-2 font-sans flex justify-end mt-1">
                            <router-link
                                v-if="!bouteille.code_saq"
                                @click="modifierBouteille(bouteille)"
                                class="material-symbols-outlined w-10 h-10 rounded-lg text-white font-semibold bg-vin-blanc mr-2"
                                :to="{
                                    name: 'modifier-bouteille',
                                    params: {
                                        bouteilleId: bouteille.id,
                                        cellierId: cellierId,
                                    },
                                }"
                            >
                                <button
                                    class="material-symbols-outlined hover:bg-gray-700 w-10 h-10 rounded-lg text-white font-semibold bg-vin-blanc mr-2 transform transition-all duration-200"
                                >
                                    edit
                                </button>
                            </router-link>
                            <div
                                v-if="bouteille.code_saq"
                                class="w-[32px] my-auto mr-2"
                            >
                                <a :href="bouteille.url_saq" target="_blank">
                                    <img src="/assets/saq.svg" alt="SAQ Icon" />
                                </a>
                            </div>
                            <!-- Bouton pour supprimer qui va jouer une animation selon l'état du booléen -->
                            <button
                                @click="supprimerBouteille(bouteille)"
                                class="hover:bg-bg-fonce w-10 h-10 rounded-lg text-white font-semibold bg-vin-rouge ml-2"
                                :class="{
                                    'material-symbols-sharp':
                                        !bouteille.animationSupprimer,
                                }"
                            >
                                <span
                                    class="transform transition-all duration-500"
                                    :class="{
                                        'material-symbols-outlined rotate-45':
                                            bouteille.animationSupprimer,
                                    }"
                                >
                                    wine_bar
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import BouteilleDataService from "@/services/BouteilleDataService.js";
import AvisDataService from "@/services/AvisDataService.js";
export default {
    name: "BouteilleComponent",
    props: {
        bouteilles: {
            type: Object,
            required: true,
            default: () => [],
        },
        cellierId: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            animationSupprimer: false,
        };
    },
    methods: {
        // Retourne l'url de l'image de la bouteille en fonction de l'url de base
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
        categorieBgColor(categorieNom) {
            switch (categorieNom) {
                case "Vin rouge":
                    return "bg-vin-rouge";
                case "Vin blanc":
                    return "bg-vin-blanc";
                case "Vin rosé":
                    return "bg-[#863D3D]";
                default:
                    return "bg-gray-500";
            }
        },
        // Supprimer la bouteille dans cellier puis l'archiver
        async modifierBouteille(bouteille) {
            this.$emit("bouteille-modifie", bouteille);
        },
        async supprimerBouteille(bouteille) {
            // Débuter l'animation de suppression
            bouteille.animationSupprimer = true;
            // Demander la suppression de la bouteille après la fin de l'animation
            setTimeout(() => {
                bouteille.animationSupprimer = false;
                this.$emit("bouteille-supprime", bouteille);
            }, 500);
        },
        async decrementQuantite(bouteille) {
            if (bouteille.pivot.quantite > 1) {
                bouteille.pivot.quantite--;
                await this.updateQuantite(bouteille);
            }
        },
        async incrementQuantite(bouteille) {
            bouteille.pivot.quantite++;
            await this.updateQuantite(bouteille);
        },

        async updateQuantite(bouteille) {
            try {
                await BouteilleDataService.updateQuantite(
                    bouteille.id,
                    bouteille.pivot.quantite,
                    this.cellierId
                );
                console.log(
                    bouteille.id,
                    bouteille.pivot.quantite,
                    this.cellierId
                );
                console.log("Quantité mise à jour avec succès");
            } catch (error) {
                console.log(error);
            }
        },
    },
};
</script>
