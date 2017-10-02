
def merge_lists(l1, l2, key):
    merged = {}
    for item in l1+l2:
        if item[key] in merged:
            merged[item[key]].update(item)
        else:
            merged[item[key]] = item
    return merged.values()


class FilterModule(object):
    def filters(self):
        filters = {
            'merge_lists': merge_lists,

        }

        return filters