$( "#cancelAccountBtn" ).click(function() {
    let addBlock = document.getElementById('addNewAccount');
    let accBlock = document.getElementById('accBlock');
    let addLink = document.getElementById('addLink');
    
    addBlock.classList.toggle('hide');
    accBlock.classList.toggle('hide');
    addLink.innerText = 'Add';
});

$( "#addLink" ).click(function() {
    let accBlock = document.getElementById('accBlock');
    let addBlock = document.getElementById('addNewAccount');

    accBlock.classList.toggle('hide');
    addBlock.classList.toggle('hide');    

    if (this.innerText == 'Add'){
        this.innerText = 'Cancel';        
    }else{
        this.innerText = 'Add';
    }
});