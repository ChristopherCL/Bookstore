$(function () {
    // showModal('to tylko test');
});

function showModal(msg) {
    //set correct type of modal
    var modal = $('#modalWindow');
    var modalTitle = modal.find('.modal-title');
    var modalBody = modal.find('.modal-body');

    modalTitle.html('UWAGA');
    modalBody.html(msg);

    modal.modal('show');
}