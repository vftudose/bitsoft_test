# bitsoft_test

Distribution algorithm description:

* Transform array 
```[
    [
        'color' => 'yellow'
        'count' => 3
    ],
    [
        'color' => 'red'
        'count' => 3
    ]
    [
        'color' => 'green'
        'count' => 3
    ]
]
```
to String of form
`'yyyrrrggg'`.

* Generate all permutations for string, when a permutation is valid (maximum 2 colors on in a box)
add it to `$results`

* Dependencies needed docker.
* Installation:
   1. `docker-compose -f docker-compose.yml build` 
   2. `docker build -f docker-compose.yml up`
   3. Access the project at http://localhost:8000/
