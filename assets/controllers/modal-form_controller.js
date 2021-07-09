import { Controller } from 'stimulus';
import { Modal } from 'bootstrap';
import $ from 'jquery'
import { useDispatch } from 'stimulus-use';

export default class extends Controller {
    static targets = ['modal', 'modalBody'];
    static values = {
        formUrl: String,
    }
    modal = null;

    connect()
    {
        useDispatch(this);
    }

    async openModal(event)
    {
        this.modalBodyTarget.innerHTML = 'loading...';
        this.modal = new Modal(this.modalTarget);
        this.modal.show();

        this.modalBodyTarget.innerHTML = await $.ajax(this.formUrlValue);
    }

    async submitForm(event) {
        event.preventDefault();
        const form = $(this.modalBodyTarget).find('form');

        var formData = new FormData(form[0]);

        try {
            this.modalBodyTarget.innerHTML = await $.ajax({
                url: this.formUrlValue,
                method: 'post',
                contentType: false,
                processData: false,
                data: formData
            })
            this.modal.hide();
            this.dispatch('success');
        } catch (e) {
            this.modalBodyTarget.innerHTML = e.responseText;
        }
    }
}