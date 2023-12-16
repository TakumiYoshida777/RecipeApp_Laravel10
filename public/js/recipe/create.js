'use strict';

const stepNo = document.querySelectorAll(".stepNo");

const steps = document.getElementById('steps');
const stepDeleteIcons = document.querySelectorAll(".step-delete");
const stepAddIcon = document.querySelector(".step-add");
const oneStepRecord = document.querySelector(".step");
console.log(oneStepRecord, "oneStepRecord");


/**
 * 番号を振りなおす
 */
const sortNomber = () => {
    const items = document.querySelectorAll(".step");
    items.forEach((item, index) => {
        item.querySelector('.step-number').textContent = '手順' + (index + 1);
    });
}

/**
 * 削除する
 * @param {} e
 */
const handleStepDelete = (e) => {
    e.target.closest('.step').remove();
    sortNomber();
}

const sortable = Sortable.create(steps, {
    //オプションを入力
    animation: 150,
    handle: '.handle',
    onEnd: sortNomber
});

console.log(steps, "steps");

const addStep = (e) => {
    const addStep = steps.appendChild(oneStepRecord.cloneNode(true));
    sortNomber();
    addStep.querySelector('.step-delete').addEventListener('click', handleStepDelete);
}

stepAddIcon.addEventListener('click', (e) => addStep());


stepDeleteIcons.forEach((item) => {
    item.addEventListener('click', handleStepDelete);
})
