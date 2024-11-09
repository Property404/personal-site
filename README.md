# Dagan's Personal Site

Site hosted at <https://dagans.dev>

## Install build dependencies

### Required dependencies

* `npm`
* `git`
* `bash`
* `cargo`
  (install with `curl --proto '=https' --tlsv1.3 -sSf https://sh.rustup.rs | sh`)

### Optional dependencies

* `python`

### Install rust tools and targets

```
cargo install minijinja-cli
```

## Hosting locally

```bash
$ git clone --recursive git@github.com:Property404/personal-site
...
$ cd personal-site
...
$ ./setup.bash
...
python3 -m http.server -d dist/
```

## License

AGPL-3.0
