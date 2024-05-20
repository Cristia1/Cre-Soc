import { defineStore } from 'pinia';
import 'vue-croppa/dist/vue-croppa.css';
import VueCropper from 'vue-croppa';

export const useGeneralStore = defineStore('general', {
    state: () => ({
        isPostOverlay: false,
        isCropperModal: false,
        isImageDisplay: null,
    }),
    plugins: [VueCropper.plugin], 
    persist: true,
});
