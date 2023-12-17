'use strict';

const stepNo = document.querySelectorAll(".stepNo");
const steps = document.getElementById('steps');
const ingredients = document.getElementById('ingredients');
const stepDeleteIcons = document.querySelectorAll(".step-delete");
const stepAddIcon = document.querySelector(".step-add");
const ingredientAddIcon = document.querySelector(".ingredient-add");
const oneStepRecord = document.querySelector(".step");
const ingredientItem = document.querySelector(".ingredient-item");


//画像
const preview = document.getElementById('preview');
const image = document.getElementById('image-data');
image.addEventListener('change', (e) => {
    let file = e.target.files[0];
    if(file){
        let reader = new FileReader();
        reader.onload = (e) => {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

/**
 * 番号を振りなおす
 */
const sortNomber = () => {
    const items = document.querySelectorAll(".step");
    items.forEach((item, index) => {
        item.querySelector('.step-number').textContent = '手順' + (index + 1);
    });
}

//材料のrecordのインデックスを順番に振りなおす
const indexRestartIngredent = () => {
    const items = ingredients.querySelectorAll('.ingredient-item');
    items.forEach(function(item, index) {
        item.querySelector('.ingredient-name').name = `ingredients[${index}][name]`;
        item.querySelector('.ingredient-quantity').name = `ingredients[${index}][quantity]`;
    });
}


/**
 * ステップを削除する
 * @param {} e
 */
const handleRecodeDelete = (e) => {
    if(e.target.closest('.step')){
        e.target.closest('.step').remove();
        sortNomber();
    }
    else if(e.target.closest('.ingredient-item')){
        e.target.closest('.ingredient-item').remove();
        indexRestartIngredent();

    }
}

/**
 * stepsをソートする
 */
const sortableSteps = Sortable.create(steps, {
    //オプションを入力
    animation: 150,
    handle: '.handle',
    onEnd: sortNomber
});

/**
 * ingredientsをソートする
 */
const sortableIngredients = Sortable.create(ingredients, {
    //オプションを入力
    animation: 150,
    handle: '.handle',
    onEnd: indexRestartIngredent
});

console.log(steps, "steps");



/**
 * 行を追加する
 * @param {*} e
 */
const addRecord = (e) => {
    //ステップ
    if(e.target.closest('.step-add')){
        const addRecord = steps.appendChild(oneStepRecord.cloneNode(true));
        sortNomber();
        addRecord.querySelector('.step-delete').addEventListener('click',handleRecodeDelete);
        //クローンした行の入力値をクリア
        const items = steps.querySelectorAll('.step');
        let lastItems = items[items.length - 1];
        console.log(lastItems.querySelector('input'), "lastItems");
        lastItems.querySelector('input').value = '';
    }
    //材料
    else if(e.target.closest('.ingredient-add')){
        // const newIngredientItem =ingredientItem.value="";
        // console.log(ingredientItem)
        const addRecord = ingredients.appendChild(ingredientItem.cloneNode(true));
        sortNomber();
        addRecord.querySelector('.step-delete').addEventListener('click',handleRecodeDelete);
        indexRestartIngredent();
        //クローンした行の入力値をクリア
        const items = ingredients.querySelectorAll('.ingredient-item');
        let lastItems = items[items.length - 1];
        console.log(lastItems.querySelector('input'), "lastItems");
        lastItems.querySelector('input').value = '';
    }
}




/**************押下処理****************/

/**
 * ステップのプラスボタン押下処理
 */
stepAddIcon.addEventListener('click',addRecord);

/**
 * 材料のプラスボタン押下処理
 */
ingredientAddIcon.addEventListener('click',(e) => {
    console.log(e.target.closest('.ingredient-add'), "材料のプラスボタン押下処理");
    addRecord(e);
    indexRestartIngredent();
});

/**
 * 削除ボタン押下処理
 */
stepDeleteIcons.forEach((item) => {
    item.addEventListener('click',handleRecodeDelete);
})


//insert時のrecordのインデックスの振り直し処理
