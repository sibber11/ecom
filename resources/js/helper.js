export function submitForm(_method, _form, _url){
    if (_method === 'post'){
        _form.post(_url)
    }
    if (_method === 'patch'){
        _form.transform(({ ...data }) => ({
            _method: 'patch',
            ...data,
        }))
        _form.post(_url)
    }
}
