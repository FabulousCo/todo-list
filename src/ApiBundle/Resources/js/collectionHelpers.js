export function removeObjectFromCollection(object, collection) {

    collection.forEach((item, key) => {
        if (item.id === object.id) {
            return collection.splice(key, 1);
        }
    });

}

export function editObjectFromCollection(object, collection) {

    collection.forEach((item, key) => {
        if (item.id === object.id) {
            return collection[key] = object;
        }
    });

}

export function findById(id, collection) {

    if (id === '') return false;

    return collection.find(function(object) {
        return object.id === parseInt(id);
    });

}