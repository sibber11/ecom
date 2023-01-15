export function submitForm(_method, _form, _url){
    if (_method === 'post'){
        _form.post(_url)
    }
    if (_method === 'patch'){
        _form._method = 'patch'
        _form.post(_url)
    }
}
