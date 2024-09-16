
// подгрузка вью в главный блок в зависимости от переданного наименования и места размещения
function SwapView(whatView, forBLock = "inner") {
    const element = document.getElementById(forBLock);
    $.ajax({
        url: 'views/' + whatView + '.php',
        async: false,
        method: 'GET',
        dataType: 'html',
        success: function (data) {
            element.innerHTML = data;
        }
    });
    if (forBLock == "inner") {
        localStorage.setItem('last-page-visited', whatView);
    }
}

// подгрузка списка проектов из БД
function LoadRecentProjectsList() {
    $(document).ready(function () {
        const elToAppend = document.getElementById("recent-list");
        $.ajax({
            url: 'libs/GetProjectsFromDb.php',
            cache: false,
            dataType: "HTML",
            type: 'POST',
            success: function (data) {
                elToAppend.innerHTML = data;
            }
        });
    });
}

// добавление проекта в БД
function CreateNewProject() {
    const nameOfProject = document.getElementById("name-of-project").value;
    const authorOfProject = document.getElementById("author-of-project").value;
    const descOfProject = document.getElementById("desc-of-project").value;
    const damageErrorsStatus = document.getElementById("status-of-worth-errors").checked;
    const today = new Date().toLocaleString();
    if (nameOfProject == '' || authorOfProject == '' || descOfProject == '') {
        alert('Все поля должны быть заполнены!');
        return false;
    } else {
        $.ajax({
            url: 'libs/AddNewProjectToDb.php',
            async: false,
            method: 'POST',
            data: {
                "nameOfProject": nameOfProject,
                "authorOfProject": authorOfProject,
                "descOfProject": descOfProject,
                "damageErrorsStatus": damageErrorsStatus,
                "dateOfCreate": today
            }
        });
        return true;
    }
}

// очистка проектов в БД
function ClearRecentProjectList() {
    const countOfProjectsAtPage = document.getElementsByClassName("recent-list-item-block");
    if (countOfProjectsAtPage.length == 0) return;
    if (confirm('Удалить сохраненные проекты?')) {
        $.ajax({
            url: 'libs/ClearProjectsDb.php',
            async: false,
            method: 'POST',
            success: function () {
                LoadRecentProjectsList();
            }
        });
    }
}

// подгрузка стартовой страницы
function LoadStartPage(back = true) {
    $(document).ready(function () {
        const whereToGo = localStorage.getItem('last-page-visited') == null || back ? "start" : localStorage.getItem('last-page-visited');
        SwapView(whereToGo);
        if (whereToGo == "start") {
            LoadRecentProjectsList();
        }
    });
}

// подтверждение создания нового проекта
function ApplyNewProject() {
    $(document).ready(function () {
        if (CreateNewProject()) {
            LoadStartPage();
        }
    });
}

// открытие проекта
function OpenProject(projectId, projectStage = 0) {
    localStorage.setItem('last-project-opened', projectId);
    $.ajax({
        url: 'libs/OpenProject.php',
        cache: false,
        data: {
            "projectId": projectId,
            "projectStage": projectStage
        },
        dataType: "HTML",
        type: 'POST',
        success: function (data) {
            const elToAppend = document.getElementById("inner");
            elToAppend.innerHTML = data;
        }
    });
}

// добавление значения в БД
function AddValueToDb(typeOfValues) {
    const valueToAdd = document.getElementById("new-" + typeOfValues + "-input").value;
    if (valueToAdd !== "") {
        document.getElementById("new-" + typeOfValues + "-input").value = "";
        $.ajax({
            url: 'libs/AddOptionsValueToDb.php',
            async: false,
            method: 'POST',
            data: {
                "tableName": typeOfValues,
                "columnName": typeOfValues,
                "valueToAdd": valueToAdd
            },
            success: function () {
                SwapView("options");
            }
        });
    } else {
        alert("Для начала заполните поле новым значением!");
    }

}

// удалить отмеченные значения в опциях из БД
function DeleteValuesFromDb() {
    const allCheckboxes = document.querySelectorAll('input[type="checkbox"]');
    const checkedCheckboxesWithData = Array.from(allCheckboxes).filter(checkbox => {
        return checkbox.checked && checkbox.hasAttribute('data-id');
    });
    if (checkedCheckboxesWithData.length !== 0) {
        const arrOfActivesToDelete = Array.from(checkedCheckboxesWithData).filter(checkbox => {
            return checkbox.dataset.type === "active";
        });
        const arrOfPlacesToDelete = Array.from(checkedCheckboxesWithData).filter(checkbox => {
            return checkbox.dataset.type === "place";
        });
        const arrOfCountermeasuresToDelete = Array.from(checkedCheckboxesWithData).filter(checkbox => {
            return checkbox.dataset.type === "countermeasure";
        });
        const arrOfThreatsToDelete = Array.from(checkedCheckboxesWithData).filter(checkbox => {
            return checkbox.dataset.type === "threat";
        });
        const activesJson = JSON.stringify(Array.from(arrOfActivesToDelete).map(item => item.dataset.id));
        const placesJson = JSON.stringify(Array.from(arrOfPlacesToDelete).map(item => item.dataset.id));
        const countermeasuresJson = JSON.stringify(Array.from(arrOfCountermeasuresToDelete).map(item => item.dataset.id));
        const threatsJson = JSON.stringify(Array.from(arrOfThreatsToDelete).map(item => item.dataset.id));

        $.ajax({
            url: 'libs/DeleteOptionsValuesFromDb.php',
            async: false,
            method: 'POST',
            data: {
                "actives": activesJson,
                "places": placesJson,
                "countermeasures": countermeasuresJson,
                "threats": threatsJson
            },
            success: function () {
                SwapView("options");
            }
        });

    }
}

// изменить выделение значений столбца в опциях
function SwapAllValuesAtOptionsColumns(e) {
    element = e;
    checkBoxStatus = element.checked;
    typeOfColumn = element.getAttribute('data-inner-type');
    const allCheckboxes = document.querySelectorAll('[data-type="' + typeOfColumn + '"]');
    allCheckboxes.forEach(checkbox => {
        checkbox.checked = checkBoxStatus;
    });
}

// обработчик импорта опций из файла
function ImportOptions() {
    const fileData = $('#fileInput').prop('files')[0];
    const formData = new FormData();
    formData.append('file', fileData);
    $.ajax({
        url: 'libs/ImportOptionsValuesToDb.php',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: 'POST',
        success: function () {
            SwapView("options");
        }
    });
}

// обработчик импорта активов из файла
function ImportActives() {
    const fileData = $('#fileInput').prop('files')[0];
    const formData = new FormData();
    formData.append('file', fileData);
    const maxVulnerabilityValue = document.getElementsByClassName("ia-max-vulnerability")[0].getAttribute("max");
    const maxWorthValue = document.getElementsByClassName("ia-max-worth")[0].getAttribute("max");
    formData.append('maxWorth', maxWorthValue);
    formData.append('maxVulnerability', maxVulnerabilityValue);
    $.ajax({
        url: 'libs/ImportActivesValues.php',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        dataType: "HTML",
        type: 'POST',
        success: function (data) {
            const elToAppend = document.getElementById("block-with-active-rows");
            elToAppend.innerHTML = data;
        }
    });
    document.getElementById("fileInput").value = "";
    EnableSaveButton();
}

// скачивание файла по ссылке
function DownloadFile(uri, name) {
    var link = document.createElement("a");
    link.download = name;
    link.href = window.location.origin + uri;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    delete link;
}

// добавление строки для заполнения в этап заполнения активов
function AddOneMoreRowToActivesStage() {
    const allRows = document.getElementsByClassName("row-with-ia-info");
    const lastindex = allRows[allRows.length - 1].children[0].children[0].textContent.substring(2);
    const maxVulnerabilityValue = document.getElementsByClassName("ia-max-vulnerability")[0].getAttribute("max");
    const maxWorthValue = document.getElementsByClassName("ia-max-worth")[0].getAttribute("max");
    $.ajax({
        url: 'views/newrowatactivestage.php',
        cache: false,
        data: {
            "lastindex": lastindex,
            "maxVulnerabilityValue": maxVulnerabilityValue,
            "maxWorthValue": maxWorthValue
        },
        dataType: "HTML",
        type: 'POST',
        success: function (data) {
            const elToAppend = document.getElementById("block-with-active-rows");
            elToAppend.insertAdjacentHTML('beforeend', data);
        }
    });
}

// добавление строки для заполнения в этап заполнения угроз
function AddOneMoreRowToThreatsStage() {
    const allRows = document.getElementsByClassName("row-with-threat-info");
    const lastindex = allRows[allRows.length - 1].children[0].children[0].textContent.substring(2);
    const maxThreat = document.getElementsByClassName("threat-max-level")[0].getAttribute("max");
    $.ajax({
        url: 'views/newrowatthreatstage.php',
        cache: false,
        data: {
            "lastindex": lastindex,
            "maxThreatValue": maxThreat
        },
        dataType: "HTML",
        type: 'POST',
        success: function (data) {
            const elToAppend = document.getElementById("block-with-threat-rows");
            elToAppend.insertAdjacentHTML('beforeend', data);
        }
    });
}

// удаление строки заполнения актива
function DeleteRow(element) {
    if (document.getElementsByClassName("row-with-ia-info").length > 1 || document.getElementsByClassName("row-with-threat-info").length > 1 || document.getElementsByClassName("row-with-countermeasure-info").length > 1) {
        const parent = element.parentElement;
        parent.parentElement.remove();
    }
}

// сбросить поля этапа заполнения активов
function ResetSecondStageRows() {
    const maxVulnerabilityValue = document.getElementsByClassName("ia-max-vulnerability")[0].getAttribute("max");
    const maxWorthValue = document.getElementsByClassName("ia-max-worth")[0].getAttribute("max");
    $.ajax({
        url: 'views/newrowatactivestage.php',
        cache: false,
        dataType: "HTML",
        type: 'POST',
        data: {
            "maxVulnerabilityValue": maxVulnerabilityValue,
            "maxWorthValue": maxWorthValue
        },
        success: function (data) {
            const elToAppend = document.getElementById("block-with-active-rows");
            elToAppend.innerHTML = data;
            document.getElementById("save-button").disabled = true;
            document.getElementById("next-stage-button").disabled = true;
        }
    });
}


// сбросить поля этапа заполнения активов
function ResetThirdStageRows() {
    const maxThreat = document.getElementsByClassName("threat-max-level")[0].getAttribute("max");
    $.ajax({
        url: 'views/newrowatthreatstage.php',
        cache: false,
        dataType: "HTML",
        type: 'POST',
        data: {
            "maxThreatValue": maxThreat
        },
        success: function (data) {
            const elToAppend = document.getElementById("block-with-threat-rows");
            elToAppend.innerHTML = data;
            document.getElementById("save-button").disabled = true;
            document.getElementById("next-stage-button").disabled = true;
        }
    });
}

// сбросить поля этапа заполнения активов
function ResetSeventhStageRows() {
    $.ajax({
        url: 'views/newrowatcountermeasurestage.php',
        cache: false,
        dataType: "HTML",
        type: 'POST',
        success: function (data) {
            const elToAppend = document.getElementById("block-with-countermeasure-rows");
            elToAppend.innerHTML = data;
            document.getElementById("save-button").disabled = true;
            document.getElementById("next-stage-button").disabled = true;
        }
    });
}

// очистка всех значений опций в БД
function ClearAllOptions() {
    if (confirm('Удалить все значения списков?')) {
        $.ajax({
            url: 'libs/ClearAllOptions.php',
            async: false,
            method: 'POST',
            success: function () {
                SwapView("options");
            }
        });
    }
}

// открытие опций проекта
function OpenProjectOptions(projectId) {
    $.ajax({
        url: 'views/projectoptions.php',
        cache: false,
        dataType: "HTML",
        data: {
            "projectId": projectId
        },
        type: 'POST',
        success: function (data) {
            const elToAppend = document.getElementById("inner");
            elToAppend.innerHTML = data;
        }
    });
}

// обновление данных проекта в БД
function UpdateProjectInfo() {
    const nameOfProject = document.getElementById("name-of-project").value;
    const authorOfProject = document.getElementById("author-of-project").value;
    const descOfProject = document.getElementById("desc-of-project").value;
    const damageErrorsStatus = document.getElementById("status-of-worth-errors").checked;
    if (nameOfProject == '' || authorOfProject == '' || descOfProject == '') {
        alert('Все поля должны быть заполнены!');
    } else {
        $.ajax({
            url: 'libs/UpdateProjectInfoAtDb.php',
            async: false,
            method: 'POST',
            data: {
                "nameOfProject": nameOfProject,
                "authorOfProject": authorOfProject,
                "descOfProject": descOfProject,
                "damageErrorsStatus": damageErrorsStatus,
                "projectId": localStorage.getItem('last-project-opened')
            },
            success: function () {
                LoadStartPage();
            }
        });
    }
}

// очистка проектов в БД
function DeleteProject() {
    if (confirm('Удалить проект?')) {
        $.ajax({
            url: 'libs/DeleteProject.php',
            async: false,
            method: 'POST',
            data: {
                "projectId": localStorage.getItem('last-project-opened')
            },
            success: function () {
                LoadStartPage();
            }
        });
    }
}

// генерация таблицы параметров
function GenerateParametersTable() {
    const minThreatValue = document.getElementById("min-threat-value").value;
    const maxThreatValue = document.getElementById("max-threat-value").value;
    const minVulnerabilityValue = document.getElementById("min-vulnerability-value").value;
    const maxVulnerabilityValue = document.getElementById("max-vulnerability-value").value;
    const minWorthValue = document.getElementById("min-worth-value").value;
    const maxWorthValue = document.getElementById("max-worth-value").value;
    const maxIgnoreValue = document.getElementById("max-ignore-metrics-summ").value;
    const minCriticValue = document.getElementById("min-critic-metrics-summ").value;
    if ((Number(minThreatValue) < Number(maxThreatValue)) & (Number(minVulnerabilityValue) < Number(maxVulnerabilityValue)) & (Number(minWorthValue) < Number(maxWorthValue))) {
        $.ajax({
            url: 'views/parameterstable.php',
            cache: false,
            dataType: "HTML",
            data: {
                "minThreatValue": minThreatValue,
                "maxThreatValue": maxThreatValue,
                "minVulnerabilityValue": minVulnerabilityValue,
                "maxVulnerabilityValue": maxVulnerabilityValue,
                "minWorthValue": minWorthValue,
                "maxWorthValue": maxWorthValue
            },
            type: 'POST',
            success: function (data) {
                const elToAppend = document.getElementById("block-table-metrics");
                elToAppend.innerHTML = data;
                let summCells = document.getElementsByClassName("summ-cell");
                for (let index = 0; index < summCells.length; index++) {
                    const threatValue = Number(summCells[index].dataset.threatValue);
                    const vulnerabilityValue = Number(summCells[index].dataset.vulnerabilityValue);
                    const worthValue = Number(summCells[index].dataset.worthValue);
                    summCells[index].textContent = (threatValue + vulnerabilityValue + worthValue);
                    summCells[index].setAttribute("title", "Сумма: уровень угроз = " + threatValue + ", уровень уязвимости = " + vulnerabilityValue + ", уровень ценности актива = " + worthValue);
                    if (Number(summCells[index].textContent) <= Number(maxIgnoreValue)) {
                        summCells[index].classList.add("ignore-summ");
                    };
                    if (Number(summCells[index].textContent) >= Number(minCriticValue)) {
                        summCells[index].classList.add("critic-summ");
                    }
                }
            }
        });
    } else {
        alert("Максимальные значения не могут быть меньше минимальных");
    }

}

// сохранение результатов ввода 1 этапа
function SaveFirstStageResult(restored = false) {
    let needToStop = false;
    if (restored) {
        if (confirm("Изменение информации очистит информацию на последующих этапах") == false) {
            needToStop = true;
        }
    }
    if (needToStop) return;
    const minThreatValue = document.getElementById("min-threat-value").value;
    const maxThreatValue = document.getElementById("max-threat-value").value;
    const minVulnerabilityValue = document.getElementById("min-vulnerability-value").value;
    const maxVulnerabilityValue = document.getElementById("max-vulnerability-value").value;
    const minWorthValue = document.getElementById("min-worth-value").value;
    const maxWorthValue = document.getElementById("max-worth-value").value;
    const maxIgnoreValue = document.getElementById("max-ignore-metrics-summ").value;
    const minCriticValue = document.getElementById("min-critic-metrics-summ").value;

    if ((Number(maxIgnoreValue) < Number(minCriticValue)) & (Number(minThreatValue) < Number(maxThreatValue)) & (Number(minVulnerabilityValue) < Number(maxVulnerabilityValue)) & (Number(minWorthValue) < Number(maxWorthValue))) {
        $.ajax({
            url: 'libs/SaveFirstStageResults.php',
            cache: false,
            data: {
                "minThreatValue": minThreatValue,
                "maxThreatValue": maxThreatValue,
                "minVulnerabilityValue": minVulnerabilityValue,
                "maxVulnerabilityValue": maxVulnerabilityValue,
                "minWorthValue": minWorthValue,
                "maxWorthValue": maxWorthValue,
                "maxIgnoreValue": maxIgnoreValue,
                "minCriticValue": minCriticValue,
                "projectId": localStorage.getItem('last-project-opened')
            },
            type: 'POST',
            success: function () {
                document.getElementById("next-stage-button").disabled = false;
                document.getElementById("save-button").disabled = true;
            }
        });
    } else {
        alert("Максимальные значения не могут быть меньше минимальных, а суммы допустимых и критичных пересекаться");
    }
}

// включение кнопки сохранения
function EnableSaveButton() {
    document.getElementById("save-button").disabled = false;
    document.getElementById("next-stage-button").disabled = true;
}

// отметить этап выполненным
function SetStageCompleted(projectId, currentStage) {
    if (confirm("Подтвердите изменение актуального этапа")) {
        $.ajax({
            url: 'libs/SetStageCompleted.php',
            cache: false,
            data: {
                "projectId": projectId,
                "currentStage": currentStage
            },
            type: 'POST',
            success: function () {
                OpenProject(projectId);
            }
        });
    }
}

// сохранение результатов ввода информации об активах
function SaveSecondStageResult(restored = false) {
    let needToStop = false;
    if (restored) {
        if (confirm("Изменение информации очистит информацию на последующих этапах") == false) {
            needToStop = true;
        }
    }
    if (needToStop) return;
    const allRows = document.getElementsByClassName("row-with-ia-info");
    let arrWithData = [];
    needToStop = false;
    let errorText = "";
    const maxVulnerabilityValue = document.getElementsByClassName("ia-max-vulnerability")[0].getAttribute("max");
    const maxWorthValue = document.getElementsByClassName("ia-max-worth")[0].getAttribute("max");
    for (let index = 0; index < allRows.length; index++) {
        let objectWithData = {};
        objectWithData.idOfActive = allRows[index].dataset.id;
        objectWithData.activeName = allRows[index].children[1].children[0].value
        objectWithData.activeOwner = allRows[index].children[2].children[0].value
        objectWithData.activeType = allRows[index].children[3].children[0].value
        objectWithData.activeWorth = allRows[index].children[4].children[0].value
        objectWithData.activePlace = allRows[index].children[5].children[0].value
        objectWithData.activeVulnerability = allRows[index].children[6].children[0].value
        if (objectWithData.activeName == "" || objectWithData.activePlace == "" || objectWithData.activeOwner == "" || objectWithData.activeType == "") {
            needToStop = true;
            errorText = "Все добавленные строки должны быть заполнены";
            break;
        }
        if (objectWithData.activeWorth > maxWorthValue || objectWithData.activeVulnerability > maxVulnerabilityValue) {
            needToStop = true;
            errorText = "Значения ценности и уязвимости не могут быть выше установленных ранее";
            break;
        }
        arrWithData.push(objectWithData);
    }
    if (needToStop) {
        alert(errorText);
    } else {
        dataToSend = arrWithData;
        $.ajax({
            url: 'libs/SaveSecondStageResults.php',
            cache: false,
            data: {
                "activesData": dataToSend,
                "projectId": localStorage.getItem('last-project-opened')
            },
            type: 'POST',
            success: function () {
                document.getElementById("next-stage-button").disabled = false;
                document.getElementById("save-button").disabled = true;
            }
        });
    }
}

// сохранение результатов ввода информации об угрозах
function SaveThirdStageResult(restored = false) {
    let needToStop = false;
    if (restored) {
        if (confirm("Изменение информации очистит информацию на последующих этапах") == false) {
            needToStop = true;
        }
    }
    if (needToStop) return;
    const allRows = document.getElementsByClassName("row-with-threat-info");
    let arrWithData = [];
    needToStop = false;
    let errorText = "";
    const maxThreat = document.getElementsByClassName("threat-max-level")[0].getAttribute("max");
    for (let index = 0; index < allRows.length; index++) {
        let objectWithData = {};
        objectWithData.idOfThreat = allRows[index].dataset.id;
        objectWithData.threatName = allRows[index].children[1].children[0].value;
        objectWithData.threatLevel = allRows[index].children[2].children[0].value;
        if (objectWithData.threatName == "") {
            needToStop = true;
            errorText = "Все добавленные строки должны быть заполнены";
            break;
        }
        if (objectWithData.threatLevel > maxThreat) {
            needToStop = true;
            errorText = "Значение уровня угрозы не может быть выше установленного ранее";
            break;
        }
        arrWithData.push(objectWithData);
    }
    if (needToStop) {
        alert(errorText);
    } else {
        dataToSend = arrWithData;
        $.ajax({
            url: 'libs/SaveThirdStageResults.php',
            cache: false,
            data: {
                "threatsData": dataToSend,
                "projectId": localStorage.getItem('last-project-opened')
            },
            type: 'POST',
            success: function () {
                document.getElementById("next-stage-button").disabled = false;
                document.getElementById("save-button").disabled = true;
            }
        });
    }
}

// обработчик импорта угроз из файла
function ImportThreats() {
    const fileData = $('#fileInput').prop('files')[0];
    const formData = new FormData();
    formData.append('file', fileData);
    const maxThreat = document.getElementsByClassName("threat-max-level")[0].getAttribute("max");
    formData.append('maxThreat', maxThreat);
    $.ajax({
        url: 'libs/ImportThreatsValues.php',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        dataType: "HTML",
        type: 'POST',
        success: function (data) {
            const elToAppend = document.getElementById("block-with-threat-rows");
            elToAppend.innerHTML = data;
        }
    });
    document.getElementById("fileInput").value = "";
    EnableSaveButton();
}

// обработчик импорта угроз из файла
function ImportCountermeasures() {
    const fileData = $('#fileInput').prop('files')[0];
    const formData = new FormData();
    formData.append('file', fileData);
    $.ajax({
        url: 'libs/ImportCountermeasuresValues.php',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        dataType: "HTML",
        type: 'POST',
        success: function (data) {
            const elToAppend = document.getElementById("block-with-countermeasure-rows");
            elToAppend.innerHTML = data;
        }
    });
    document.getElementById("fileInput").value = "";
    EnableSaveButton();
}

// открытие модального окна для привязки угроз
function OpenModifyThreatsWindow(element) {
    let restoredSignElement = document.getElementsByClassName("restored");
    let needToStop = false
    if (restoredSignElement.length != 0) {
        if (!confirm("Изменение требует очистки данных последующих этапов")) {
            needToStop = true;
        } else {
            needToStop = ResetAllActiveThreats(false);
        }
    }
    if (!needToStop) {
        if (restoredSignElement.length != 0) {
            restoredSignElement[0].classList.remove("restored");
        }
        $.ajax({
            url: 'libs/ReturnAssignedThreats.php',
            cache: false,
            dataType: "HTML",
            data: {
                "projectId": element.dataset.projectId,
                "activeId": element.dataset.activeId,
                "activeName": element.dataset.activeName
            },
            type: 'POST',
            success: function (data) {
                const elToAppend = document.getElementById("body");
                elToAppend.insertAdjacentHTML('beforebegin', data);
                removeDuplicates('threats');
            }
        });

    }

}

// закрытие модального окна для привязки угроз
function CloseModal() {
    document.getElementById("modal-window-background").remove();
}

// перенос угрозы между селектами
function AssignThreat(element) {
    let selectToReplaceId;
    if (element.parentElement.id == "unselected-threats") {
        selectToReplaceId = "selected-threats";
    } else {
        selectToReplaceId = "unselected-threats";
    }
    document.getElementById(selectToReplaceId).appendChild(element);
}

// актуализация привязки угроз к активу
function ActualizeThreats(projectId, activeId) {
    let arrWithData = [];
    let allOptions = document.getElementById("selected-threats").children;
    if (allOptions.length != 0) {
        for (let index = 0; index < allOptions.length; index++) {
            let objectWithData = {};
            objectWithData.id = allOptions[index].value;
            objectWithData.value = allOptions[index].textContent;
            arrWithData.push(objectWithData);
        }
    } else {
        arrWithData = "none";
    }
    $.ajax({
        url: 'libs/ActualizeThreats.php',
        cache: false,
        dataType: "HTML",
        type: 'POST',
        data: {
            "projectId": projectId,
            "activeId": activeId,
            "arrWithData": arrWithData
        },
        success: function (data) {
            const elToAppend = document.getElementById("active-" + activeId + "-cubes-line");
            elToAppend.innerHTML = data;
            CloseModal();
        }
    });
}

// сброс привязок всех угроз
function ResetAllActiveThreats(isReset) {
    if (isReset) {
        const neededElements = document.getElementsByClassName("threat-cube");
        if (neededElements.length == 0) {
            return;
        }
    }
    let messageConfirm;
    if (isReset) {
        messageConfirm = "Действие удалит все данные текущего и последующих этапов";
    } else {
        messageConfirm = "Действие удалит данные последующих этапов";
    }
    if (confirm(messageConfirm)) {
        const projectId = localStorage.getItem('last-project-opened');
        $.ajax({
            url: 'libs/ClearAllThreatsAssigns.php',
            cache: false,
            type: 'POST',
            data: {
                "projectId": projectId,
                "isReset": isReset
            },
            success: function () {
                if (isReset) {
                    OpenProject(projectId);
                }
            }
        });
    } else {
        return true;
    }
}

// отметка выполненным этапа привязки угроз
function SetAssignThreatsStageCompleted(projectId, currentStage) {
    const neededElements = document.getElementsByClassName("not-completed");
    if (neededElements.length == 0) {
        SetStageCompleted(projectId, currentStage);
    } else {
        alert("Не всем активам присвоены угрозы");
    }
}

// сохранение результатов этапа указания диапазонов
function SaveFiveStageResult(restored = false) {
    let needToStop = false;
    if (restored) {
        if (confirm("Изменение информации очистит информацию на последующих этапах") == false) {
            needToStop = true;
        }
    }
    if (needToStop) return;
    let dataOfRanges = [];
    const rowsWithValues = document.getElementsByClassName("row-with-range");
    let highestValue = -1;
    let errorText = "";
    for (let index = 0; index < rowsWithValues.length; index++) {
        let objectToArray = {};
        objectToArray.worthValue = rowsWithValues[index].children[0].textContent;
        objectToArray.lowerValue = rowsWithValues[index].children[1].children[0].value;
        objectToArray.upperValue = rowsWithValues[index].children[2].children[0].value;
        if (Number(objectToArray.lowerValue) < Number(objectToArray.upperValue)) {
            if (Number(highestValue) < Number(objectToArray.lowerValue)) {
                dataOfRanges.push(objectToArray);
                highestValue = objectToArray.upperValue;
            } else {
                errorText = "Значение нижней границы старшего уровня ценности должно быть больше верхней границы предыдущего уровня ценности"
                break;
            }
        } else {
            errorText = "Значение верхней границы не может быть меньше или равно нижней";
            break;
        }
    }
    if (errorText == "") {
        $.ajax({
            url: 'libs/SaveFifthStageResults.php',
            cache: false,
            data: {
                "dataOfRanges": dataOfRanges,
                "projectId": localStorage.getItem('last-project-opened')
            },
            type: 'POST',
            success: function () {
                document.getElementById("next-stage-button").disabled = false;
                document.getElementById("save-button").disabled = true;
            }
        });
    } else {
        alert(errorText);
    }
}

// сбросить поля этапа заполнения диапазонов
function ResetFifthStageRows() {
    let allInputs = document.getElementsByClassName("range-table-input");
    for (let index = 0; index < allInputs.length; index++) {
        allInputs[index].value = "0";
    }
    document.getElementById("save-button").disabled = true;
    document.getElementById("next-stage-button").disabled = true;
}

// удаление дубликатов в select
function removeDuplicates(type) {
    var select1 = document.getElementById('unselected-' + type);
    var select2 = document.getElementById('selected-' + type);
    var valuesToCheck = [];
    for (var i = 0; i < select2.options.length; i++) {
        valuesToCheck.push(select2.options[i].value);
    }
    for (var i = select1.options.length - 1; i >= 0; i--) {
        if (valuesToCheck.includes(select1.options[i].value)) {
            select1.remove(i);
        }
    }
}


// фиксация значений матрицы рисков
function FixateSixthStageResult(restored = false) {
    let needToStop = false;
    if (restored) {
        if (confirm("Изменение информации очистит информацию на последующих этапах") == false) {
            needToStop = true;
        }
    }
    if (needToStop) return;
    const damageValueCells = document.getElementsByClassName("row-of-risk-matrix");
    let dataOfDamages = [];
    for (let index = 0; index < damageValueCells.length; index++) {
        let objectToAdd = {};
        objectToAdd.damageValue = damageValueCells[index].dataset.damageOfActiveWithoutRepeat;
        objectToAdd.damageValueWithRepeat = damageValueCells[index].dataset.damageOfActiveRepeat;
        objectToAdd.rowId = damageValueCells[index].dataset.rowId;
        dataOfDamages.push(objectToAdd);
    }
    $.ajax({
        url: 'libs/FixateRisksMatrix.php',
        cache: false,
        data: {
            "dataOfDamages": dataOfDamages,
            "projectId": localStorage.getItem('last-project-opened')
        },
        type: 'POST',
        success: function () {
            document.getElementById("next-stage-button").disabled = false;
        }
    });
}

// обновление значений ущерба
function UpdateDamageValues() {
    const damageValueCells = document.getElementsByClassName("damage-value-cell");
    let statusOfDamageErrors = document.getElementById("matrix-table").dataset.damageErrors;
    let maxWorth;
    if (statusOfDamageErrors == 1) {
        statusOfDamageErrors = true;
        maxWorth = Number(document.getElementById("matrix-table").dataset.maxWorth);
    } else {
        statusOfDamageErrors = false;
    }
    let dataWithRanges;
    $.ajax({
        url: 'libs/GetRangesValues.php',
        async: false,
        dataType: "JSON",
        cache: false,
        data: {
            "projectId": localStorage.getItem('last-project-opened')
        },
        type: 'POST',
        success: function (data) {
            dataWithRanges = data;
        }
    });
    for (let index = 0; index < damageValueCells.length; index++) {
        damageValueCells[index].classList.remove("with-error");
        let localWorth = damageValueCells[index].dataset.worth;
        if (statusOfDamageErrors) {
            const localLowerValue = Math.ceil(-1);
            const localUpperValue = Math.floor(1);
            let valueToAdd = Number(Math.ceil(Math.random() * (localUpperValue - localLowerValue) + localLowerValue) + 1);
            const localChangedWorth = Number(localWorth) + Number(valueToAdd);
            if (localChangedWorth >= 0 && maxWorth >= localChangedWorth && valueToAdd != 0) {
                localWorth = localChangedWorth;
                damageValueCells[index].classList.add("with-error");
            }
        }
        const lowerValue = Math.ceil(dataWithRanges[localWorth].lowerValue);
        const upperValue = Math.floor(dataWithRanges[localWorth].upperValue);
        let newValueOfDamage = Math.ceil(Math.random() * (upperValue - lowerValue) + lowerValue) + 1;
        damageValueCells[index].textContent = newValueOfDamage;
        let elementToCheck = damageValueCells[index].parentElement;
        elementToCheck.dataset.damageOfActiveRepeat = newValueOfDamage;
        elementToCheck.dataset.damageOfActiveWithoutRepeat = newValueOfDamage;
        while (elementToCheck.nextElementSibling && elementToCheck.nextElementSibling.dataset.damageOfActiveWithoutRepeat == 0) {
            elementToCheck.nextElementSibling.dataset.damageOfActiveRepeat = newValueOfDamage;
            elementToCheck = elementToCheck.nextElementSibling;
        }
    }
}

// добавление строки для заполнения в этап заполнения контрмер
function AddOneMoreRowToCounterMeasuresStage() {
    const allRows = document.getElementsByClassName("row-with-countermeasure-info");
    const lastindex = allRows[allRows.length - 1].children[0].children[0].textContent.substring(2);
    $.ajax({
        url: 'views/newrowatcountermeasurestage.php',
        cache: false,
        data: {
            "lastindex": lastindex
        },
        dataType: "HTML",
        type: 'POST',
        success: function (data) {
            const elToAppend = document.getElementById("block-with-countermeasure-rows");
            elToAppend.insertAdjacentHTML('beforeend', data);
        }
    });
}

// сохранение результатов ввода информации о контрмерах
function SaveSeventhStageResult(restored = false) {
    let needToStop = false;
    if (restored) {
        if (confirm("Изменение информации очистит информацию на последующих этапах") == false) {
            needToStop = true;
        }
    }
    if (needToStop) return;
    const allRows = document.getElementsByClassName("row-with-countermeasure-info");
    let arrWithData = [];
    needToStop = false;
    let errorText = "";
    for (let index = 0; index < allRows.length; index++) {
        let objectWithData = {};
        objectWithData.idOfCountermeasure = allRows[index].dataset.id;
        objectWithData.countermeasureName = allRows[index].children[1].children[0].value;
        objectWithData.countermeasureCost = allRows[index].children[2].children[0].value;
        if (objectWithData.countermeasureName == "") {
            needToStop = true;
            errorText = "Все добавленные строки должны быть заполнены";
            break;
        }
        arrWithData.push(objectWithData);
    }
    if (needToStop) {
        alert(errorText);
    } else {
        dataToSend = arrWithData;
        $.ajax({
            url: 'libs/SaveSeventhStageResults.php',
            cache: false,
            data: {
                "countermeasuresData": dataToSend,
                "projectId": localStorage.getItem('last-project-opened')
            },
            type: 'POST',
            success: function () {
                document.getElementById("next-stage-button").disabled = false;
                document.getElementById("save-button").disabled = true;
            }
        });
    }
}

// открытие модального окна для привязки контрмеры
function OpenModifyCountermeasuresWindow(element) {
    let restoredSignElement = document.getElementsByClassName("restored");
    let needToStop = false
    if (restoredSignElement.length != 0) {
        if (!confirm("Изменение требует очистки данных последующих этапов")) {
            needToStop = true;
        } else {
            needToStop = ResetAllCountermeasures(false);
        }
    }
    if (!needToStop) {
        if (restoredSignElement.length != 0) {
            restoredSignElement[0].classList.remove("restored");
        }
        $.ajax({
            url: 'libs/ReturnAssignedCountermeasures.php',
            cache: false,
            dataType: "HTML",
            data: {
                "projectId": element.dataset.projectId,
                "riskId": element.dataset.riskId,
                "threatName": element.dataset.threatName,
                "damage": element.dataset.damage,
                "metric": element.dataset.metric,
                "activeName": element.dataset.activeName
            },
            type: 'POST',
            success: function (data) {
                const elToAppend = document.getElementById("body");
                elToAppend.insertAdjacentHTML('beforebegin', data);
                removeDuplicates('countermeasures');
            }
        });

    }

}

// перенос угрозы между селектами
function AssignCountermeasure(element) {
    let selectToReplaceId;
    if (element.parentElement.id == "unselected-countermeasures") {
        selectToReplaceId = "selected-countermeasures";
    } else {
        selectToReplaceId = "unselected-countermeasures";
    }
    document.getElementById(selectToReplaceId).appendChild(element);
}

// актуализация привязки контрмер к риску
function ActualizeCountermeasures(projectId, riskId) {
    let arrWithData = [];
    let allOptions = document.getElementById("selected-countermeasures").children;
    let variant = document.getElementById("risk-variant").value;
    if (variant == "none") {
        alert('Вариант обработки должен быть выбран');
        return;
    }
    if (allOptions.length != 0) {
        for (let index = 0; index < allOptions.length; index++) {
            let objectWithData = {};
            objectWithData.id = allOptions[index].value;
            objectWithData.value = allOptions[index].textContent;
            objectWithData.cost = allOptions[index].dataset.cost;
            arrWithData.push(objectWithData);
        }
    } else {
        arrWithData = "none";
    }
    $.ajax({
        url: 'libs/ActualizeCountermeasures.php',
        cache: false,
        dataType: "HTML",
        type: 'POST',
        data: {
            "projectId": projectId,
            "riskId": riskId,
            "arrWithData": arrWithData,
            "variant": variant
        },
        success: function (data) {
            let elToAppend = document.getElementById("risk-" + riskId + "-cubes-line");
            elToAppend.innerHTML = data;
            elToAppend = document.getElementById("risk-" + riskId + "-variant");
            if (variant != "none" && arrWithData != "none") {
                elToAppend.innerHTML = '<p class="variant">' + variant + '</p>';
            } else {
                elToAppend.innerHTML = '<p class="not-completed">Вариант не выбран</p>';
            }
            CloseModal();
        }
    });
}

// сброс привязок всех контрмер
function ResetAllCountermeasures(isReset) {
    if (isReset) {
        const neededElements = document.getElementsByClassName("countermeasure-cube");
        if (neededElements.length == 0) {
            return;
        }
    }
    let messageConfirm;
    if (isReset) {
        messageConfirm = "Действие удалит все данные текущего и последующих этапов";
    } else {
        messageConfirm = "Действие удалит данные последующих этапов";
    }
    if (confirm(messageConfirm)) {
        const projectId = localStorage.getItem('last-project-opened');
        $.ajax({
            url: 'libs/ClearAllCountermeasuresAssigns.php',
            cache: false,
            type: 'POST',
            data: {
                "projectId": projectId,
                "isReset": isReset
            },
            success: function () {
                if (isReset) {
                    OpenProject(projectId);
                }
            }
        });
    } else {
        return true;
    }
}

// отметка выполненным этапа привязки контрмер
function SetAssignCountermeasuresStageCompleted(projectId, currentStage) {
    const neededElements = document.getElementsByClassName("not-completed");
    if (neededElements.length == 0) {
        SetStageCompleted(projectId, currentStage);
    } else {
        alert("Не всем рискам присвоены контрмеры");
    }
}

// сохранение результатов ввода 1 этапа
function SaveNinethStageResult(restored = false) {
    let needToStop = false;
    if (restored) {
        if (confirm("Изменение информации очистит информацию на последующих этапах") == false) {
            needToStop = true;
        }
    }
    if (needToStop) return;
    const maxMetricsSumm = document.getElementById("maxMetricsSumm").dataset.value;
    const factMetricsSumm = document.getElementById("factMetricsSumm").dataset.value;
    const statusOfErrorsOptions = document.getElementById("statusOfErrorsOptions").dataset.value;
    const potencialSummOfDamage = document.getElementById("potencialSummOfDamage").dataset.value;
    const summOfCountermeasures = document.getElementById("summOfCountermeasures").dataset.value;
    const averageDamageSumm = document.getElementById("averageDamageSumm").dataset.value;
    const maxDeviantPercent = document.getElementById("maxDeviantPercent").dataset.value;
    let rowsWithDamage = document.getElementsByClassName("damage-rows");
    let dataWithDamages = [];
    for (let index = 0; index < rowsWithDamage.length; index++) {
        let objectToAdd = {};
        objectToAdd.damage = rowsWithDamage[index].children[1].dataset.value;
        objectToAdd.deviant = rowsWithDamage[index].children[2].dataset.value;
        dataWithDamages.push(objectToAdd);
    }

    $.ajax({
        url: 'libs/SaveNinethStageResults.php',
        cache: false,
        data: {
            "dataWithDamages": dataWithDamages,
            "maxMetricsSumm": maxMetricsSumm,
            "factMetricsSumm": factMetricsSumm,
            "statusOfErrorsOptions": statusOfErrorsOptions,
            "potencialSummOfDamage": potencialSummOfDamage,
            "summOfCountermeasures": summOfCountermeasures,
            "averageDamageSumm": averageDamageSumm,
            "maxDeviantPercent": maxDeviantPercent,
            "projectId": localStorage.getItem('last-project-opened')
        },
        type: 'POST',
        success: function () {
            document.getElementById("next-stage-button").disabled = false;
        }
    });
}

// обновление значений ущерба
function UpdateDamageSummsAndDeviants(restored) {
    let projectId = localStorage.getItem('last-project-opened');
    if (!restored) {
        OpenProject(projectId, 9);
    } else {
        let errorsEnabled = document.getElementById("statusOfErrorsOptions").dataset.value;
        $.ajax({
            url: 'libs/GenerateDamageValuesAgainForJsUpdate.php',
            cache: false,
            data: {
                "errorsEnabled": errorsEnabled,
                "projectId": localStorage.getItem('last-project-opened')
            },
            type: 'POST',
            dataType: "HTML",
            success: function (data) {
                let elToAppend = document.getElementById("tbody-to-update");
                elToAppend.innerHTML = data;
            }
        });
    }
}

// формирование графика
function GenerateGraph() {
    let elementsForDamagePerStepLine = document.getElementsByClassName("damage-per-step");
    let elementsForCostPerStepLine = document.getElementsByClassName("cost-per-step");
    let elementsForProfitPerStepLine = document.getElementsByClassName("profit-per-step");
    let elementToShow = document.getElementById("container");
    let elementToHide = document.getElementById("stage-body");
    let buttonToHide = document.getElementById("menu-back-button-inner");
    let buttonToShow = document.getElementById("close-graphbutton");
    const selectElement = document.getElementById("type-of-strategy");
    let selectedIndex = selectElement.selectedIndex;
    let strategy = selectElement.options[selectedIndex].text;

    buttonToHide.style.display = "none";
    buttonToShow.style.display = "inherit";
    elementToShow.style.display = "inherit";
    elementToHide.style.display = "none";
    elementToShow.innerHTML = "";

    let dataForDamagePerStepLine = [];
    let dataForCostPerStepLine = [];
    let dataForProfitPerStepLine = [];

    for (let index = 0; index < elementsForDamagePerStepLine.length; index++) {
        dataForDamagePerStepLine.push([index, elementsForDamagePerStepLine[index].textContent]);
        dataForCostPerStepLine.push([index, elementsForCostPerStepLine[index].textContent]);
        dataForProfitPerStepLine.push([index, elementsForProfitPerStepLine[index].textContent]);
    }
    chart = anychart.line();
    var series1 = chart.line(dataForDamagePerStepLine);
    series1.labels(true);
    series1.name("Ущерб от реализации угроз");
    console.log(series1);

    var series2 = chart.line(dataForCostPerStepLine);
    series2.labels(true);
    series2.name("Стоимость внедрения контрмер");

    var series3 = chart.line(dataForProfitPerStepLine);
    series3.labels(true);
    series3.name("Прибыль от внедрения контрмер");

    // configure tooltips on the first series
    series1.tooltip().format("Ущерб на текущем шаге: {%value} тыс. руб.");

    // configure tooltips on the second series
    series2.tooltip().format("Стоимость контрмер на текущем шаге: {%value} тыс. руб.");

    // configure tooltips on the second series
    series3.tooltip().format("Прибыль от внедрения контрмер на текущем шаге: {%value} тыс. руб.");

    chart.container("container");
    chart.title('Эффект от стратегии "' + strategy + '"');
    chart.xAxis().title('Шаги взаимодействия с рисками');
    chart.yAxis().title('Величина экономических достижений, тыс. руб.');
    chart.tooltip().titleFormat(function () {
        return 'Шаг ' + this.x;
    })
    chart.legend(true);
    chart.draw();
}

// выключение графика
function CloseGraph() {
    let elementToHide = document.getElementById("container");
    let elementToShow = document.getElementById("stage-body");
    let buttonToShow = document.getElementById("menu-back-button-inner");
    let buttonToHide = document.getElementById("close-graphbutton");
    buttonToHide.style.display = "none";
    buttonToShow.style.display = "inherit";
    elementToHide.style.display = "none";
    elementToShow.style.display = "flex"
    elementToHide.innerHTML = "";
}

//смена стратегии
function SwapStrategy() {
    const projectId = localStorage.getItem('last-project-opened');
    const stategy = document.getElementById("type-of-strategy").value;
    $.ajax({
        url: 'libs/GenerateResultTable.php',
        cache: false,
        dataType: "HTML",
        type: 'POST',
        data: {
            "strategy": stategy,
            "projectId": projectId
        },
        success: function (data) {
            let elToAppend = document.getElementById("block-table-matrix");
            elToAppend.innerHTML = data;
        }
    });
}