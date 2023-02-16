<template>
    <div>
        <header>
            <div
                class="navbar-mobile--wrapper d-lg-none"
                v-bind:class="{ active: isSidebar }"
            >
                <div class="navbar-mobile">
                    <div class="navbar-mobile--head">
                        <router-link
                            class="nav-link"
                            aria-current="page"
                            to="/home"
                            v-if="authUser"
                        >
                            <img src="/images/logo.png" alt="Brand" />
                            <!-- <span class="lurc"
                ><span class="lurc1">RESEARCH</span
                ><span class="lurc2">COMMUNITY</span>
              </span> -->
                        </router-link>
                        <router-link
                            class="nav-link"
                            aria-current="page"
                            to="/"
                            v-else
                        >
                            <img src="/images/logo.png" alt="Brand" />
                            <!-- <span class="lurc"
                ><span class="lurc1">RESEARCH</span
                ><span class="lurc2">COMMUNITY</span>
              </span> -->
                        </router-link>
                        <button type="button" v-on:click="hideSidebar()">
                            <i class="lni lni-close"></i>
                        </button>
                    </div>
                    <ul class="navbar-mobile--body">
                        <li class="nav-item">
                            <router-link
                                class="nav-link"
                                aria-current="page"
                                to="/home"
                                v-if="authUser"
                                >Home</router-link
                            >
                            <router-link
                                class="nav-link"
                                aria-current="page"
                                to="/"
                                v-else
                                >Home</router-link
                            >
                        </li>

                        <li class="nav-item">
                            <router-link
                                class="nav-link"
                                aria-current="page"
                                to="/research"
                                >Research</router-link
                            >
                        </li>

                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                id="navbarDropdown"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                Departments
                            </a>

                            <ul
                                class="dropdown-menu"
                                aria-labelledby="navbarDropdown"
                            >
                                <li
                                    v-for="(
                                        department, index
                                    ) in departmentInfo"
                                    :key="index"
                                >
                                    <router-link
                                        class="dropdown-item"
                                        :to="`/department/${department.department_name}/${department.id}`"
                                        >{{
                                            department.department_name
                                        }}</router-link
                                    >
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <router-link
                                class="nav-link"
                                aria-current="page"
                                v-if="authUser.userType == 'admin'"
                                to="/admin/teachers"
                                >Add Teacher</router-link
                            >
                        </li>
                    </ul>
                </div>
            </div>

            <!-- ****connection**** -->
            <div
                class="navbar-notification--wrapper"
                v-bind:class="{ active: isAllConnection }"
            >
                <div class="navbar-notification">
                    <div class="navbar-notification--head">
                        <h5>Connections</h5>
                        <button type="button" v-on:click="hideConnection()">
                            <i class="lni lni-close"></i>
                        </button>
                    </div>
                    <div class="navbar-notification--body">
                        <button
                            @click="getConnection"
                            v-bind:class="{ btnActive: isConnection }"
                        >
                            Connections
                        </button>
                        <button
                            @click="getRequest"
                            v-bind:class="{ btnActive: isRequest }"
                        >
                            Requests
                        </button>

                        <ul v-if="isLoading == true">
                            <li class="skeleton nav-link">
                                <img />
                                <p></p>
                            </li>
                            <li class="skeleton nav-link">
                                <img />
                                <p></p>
                            </li>
                            <li class="skeleton nav-link">
                                <img />
                                <p></p>
                            </li>
                            <li class="skeleton nav-link">
                                <img />
                                <p></p>
                            </li>
                        </ul>

                        <ul
                            v-for="(connection, index) in connectionItem"
                            v-else-if="
                                isLoading == false &&
                                connectionItem != undefined &&
                                connectionItem.length > 0
                            "
                        >
                            <router-link
                                class="nav-item"
                                v-if="authUser.id == connection.from_id"
                                :to="`/profile/${connection.user2.slug}/overview`"
                            >
                                <li class="nav-link">
                                    <img :src="connection.user2.image" />

                                    <div>
                                        <p>{{ connection.user2.name }}</p>
                                        <p>
                                            {{ connection.user2.designation }}
                                        </p>
                                    </div>
                                </li>
                            </router-link>
                            <router-link
                                class="nav-item"
                                v-else-if="authUser.id == connection.to_id"
                                :to="`/profile/${connection.user1.slug}/overview`"
                            >
                                <li class="nav-link">
                                    <img :src="connection.user1.image" />

                                    <div>
                                        <p>{{ connection.user1.name }}</p>
                                        <p>
                                            {{ connection.user1.designation }}
                                        </p>
                                    </div>
                                </li>
                            </router-link>
                        </ul>

                        <div v-else>
                            <h2 class="mt-5 text-center">
                                No connection Found!!
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ****notification**** -->
            <div
                class="navbar-notification--wrapper"
                v-bind:class="{ active: isNotification }"
            >
                <div class="navbar-notification">
                    <div class="navbar-notification--head">
                        <h5>Notification</h5>
                        <button type="button" v-on:click="hideNotification()">
                            <i class="lni lni-close"></i>
                        </button>
                    </div>
                    <div class="navbar-notification--body">
                        <button
                            @click="getNotification"
                            v-bind:class="{ btnActive: isAll }"
                        >
                            All
                        </button>
                        <button
                            @click="getReadNotification"
                            v-bind:class="{ btnActive: isRead }"
                        >
                            Read
                        </button>
                        <button
                            @click="getUnreadNotification"
                            v-bind:class="{ btnActive: isUnread }"
                        >
                            Unread
                        </button>
                        <!-- <button
              @click="getRequestNotification"
              v-bind:class="{ btnActive: isRequest }"
            >
              Requests
            </button> -->
                        <ul v-if="isLoading == true">
                            <li class="skeleton nav-link">
                                <img />
                                <p></p>
                            </li>
                            <li class="skeleton nav-link">
                                <img />
                                <p></p>
                            </li>
                            <li class="skeleton nav-link">
                                <img />
                                <p></p>
                            </li>
                            <li class="skeleton nav-link">
                                <img />
                                <p></p>
                            </li>
                        </ul>
                        <ul
                            v-for="(notification, index) in notificationItem"
                            v-else-if="
                                isLoading == false &&
                                notificationItem != undefined &&
                                notificationItem.length > 0
                            "
                        >
                            <router-link
                                class="nav-item"
                                :to="`/profile/${notification.data.user_slug}/overview`"
                                v-if="
                                    notification.data.msg ==
                                        'accepted your request' ||
                                    notification.data.msg ==
                                        'requested to connect you'
                                "
                            >
                                <li
                                    class="nav-link"
                                    @click="markAsRead(index)"
                                    v-bind:class="{
                                        active: notification.read_at == null,
                                    }"
                                >
                                    <div>
                                        <img
                                            :src="notification.data.user_image"
                                        />
                                        <span
                                            class="nav-action nav-action__like"
                                            ><i
                                                class="fa-solid fa-user-group"
                                            ></i
                                        ></span>
                                    </div>
                                    <div>
                                        <router-link
                                            :to="`/profile/${notification.data.user_slug}/overview`"
                                            >{{
                                                notification.data.user_name
                                            }}</router-link
                                        >
                                        <span>{{ notification.data.msg }}</span>
                                    </div>
                                </li>
                            </router-link>
                            <router-link
                                class="nav-item"
                                :to="`/description/${notification.data.post_slug}/comments`"
                                v-else-if="
                                    notification.data.msg == 'commented your'
                                "
                            >
                                <li
                                    class="nav-link"
                                    @click="markAsRead(index)"
                                    v-bind:class="{
                                        active: notification.read_at == null,
                                    }"
                                >
                                    <div>
                                        <img
                                            :src="notification.data.user_image"
                                        />
                                        <span
                                            class="nav-action nav-action__like"
                                            ><i class="fa-solid fa-comment"></i
                                        ></span>
                                    </div>
                                    <div>
                                        <router-link
                                            :to="`/profile/${notification.data.user_slug}/overview`"
                                            >{{
                                                notification.data.user_name
                                            }}</router-link
                                        >
                                        {{
                                            notification.data.msg +
                                            " " +
                                            notification.data.post_type
                                        }}
                                    </div>
                                </li>
                            </router-link>
                            <router-link
                                class="nav-item"
                                :to="`/description/${notification.data.post_slug}/overview`"
                                v-else
                            >
                                <li
                                    class="nav-link"
                                    @click="markAsRead(index)"
                                    v-bind:class="{
                                        active: notification.read_at == null,
                                    }"
                                >
                                    <div>
                                        <img
                                            :src="notification.data.user_image"
                                        />
                                        <span
                                            class="nav-action nav-action__like"
                                            v-if="
                                                notification.data.msg ==
                                                'liked your'
                                            "
                                            ><i
                                                class="fa-solid fa-thumbs-up"
                                            ></i
                                        ></span>
                                        <span
                                            class="nav-action nav-action__upVote"
                                            v-else-if="
                                                notification.data.msg ==
                                                'up voted your'
                                            "
                                            ><i class="fa-solid fa-caret-up"></i
                                        ></span>
                                        <span
                                            class="nav-action nav-action__downVote"
                                            v-else-if="
                                                notification.data.msg ==
                                                'down voted your'
                                            "
                                            ><i
                                                class="fa-solid fa-caret-down"
                                            ></i
                                        ></span>
                                    </div>
                                    <div>
                                        <router-link
                                            :to="`/profile/${notification.data.user_slug}/overview`"
                                            >{{
                                                notification.data.user_name
                                            }}</router-link
                                        >
                                        {{
                                            notification.data.msg +
                                            " " +
                                            notification.data.post_type
                                        }}
                                    </div>
                                </li>
                            </router-link>
                        </ul>

                        <div v-else>
                            <h2 class="mt-5 text-center">
                                No Notification Found!!
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ****SearchBox**** -->
            <div
                class="navbar-search"
                v-bind:class="{ active: isSearchbar }"
                ref="searchBox"
            >
                <div class="navbar-search-input">
                    <input
                        type="search"
                        placeholder="Search..."
                        v-model="keyword"
                        :ref="`search${keyword}`"
                    />
                    <button type="button" class="search-button">
                        <i class="lni lni-search-alt" v-if="keyword == ''"></i>
                        <i
                            class="lni lni-close"
                            v-else
                            v-on:click="clearSearchBar()"
                        ></i>
                    </button>
                </div>

                <div class="navbar-search-cancel">
                    <button
                        type="button"
                        class="cancel-button"
                        v-on:click="cancelSearchBar()"
                    >
                        <i class="lni lni-close"></i>
                    </button>
                </div>
                <div
                    class="navbar-search-result"
                    v-if="Users.length > 0 && keyword.length > 0"
                >
                    <ul class="search-list w-100 c-pointer">
                        <li
                            v-for="user in Users"
                            v-if="authUser.id != user.id"
                            :key="user.id"
                            @click="getSearchedUser(user)"
                        >
                            <img :src="user.image" />
                            <div>
                                <h4>{{ user.name }}</h4>
                                <p>{{ user.designation }}</p>
                            </div>
                        </li>
                        <div
                            class="justify-content-center d-flex c-pointer p-3"
                            v-if="!loadMoreLoading"
                            @click="loadMoreUser(3)"
                        >
                            View more
                        </div>
                        <div v-if="loadMoreLoading" class="loader-sm">
                            <i
                                class="ivu-load-loop ivu-icon ivu-icon-ios-loading"
                            ></i>
                        </div>
                    </ul>
                </div>
            </div>

            <nav class="navbar navbar-expand-lg">
                <div class="container header-content">
                    <div class="navbar-item navbar-itemLogo">
                        <router-link
                            class="navbar-brand"
                            to="/home"
                            v-if="authUser"
                            ><img src="/images/logo.png" alt="Brand" />
                        </router-link>
                        <router-link class="navbar-brand" to="/" v-else
                            ><img src="/images/logo.png" alt="Brand" />
                        </router-link>
                    </div>
                    <div class="navbar-item navbar-body d-none d-lg-block">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <router-link
                                    class="nav-link"
                                    aria-current="page"
                                    to="/home"
                                    v-if="authUser"
                                    >Home</router-link
                                >
                                <router-link
                                    class="nav-link"
                                    aria-current="page"
                                    to="/"
                                    v-else
                                    >Home</router-link
                                >
                            </li>

                            <li class="nav-item">
                                <router-link
                                    class="nav-link"
                                    aria-current="page"
                                    to="/research"
                                    >Research</router-link
                                >
                            </li>

                            <li class="nav-item dropdown">
                                <a
                                    class="nav-link dropdown-toggle"
                                    id="navbarDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    Departments
                                </a>

                                <ul
                                    class="dropdown-menu"
                                    aria-labelledby="navbarDropdown"
                                >
                                    <li
                                        v-for="(
                                            department, index
                                        ) in departmentInfo"
                                        :key="index"
                                    >
                                        <router-link
                                            class="dropdown-item"
                                            :to="`/department/${department.department_name}/${department.id}`"
                                            >{{
                                                department.department_name
                                            }}</router-link
                                        >
                                    </li>
                                </ul>
                            </li>
                            <li
                                class="nav-item"
                                v-if="authUser.userType == 'admin'"
                            >
                                <router-link
                                    class="nav-link"
                                    aria-current="page"
                                    to="/admin/teachers"
                                    >Add Teacher</router-link
                                >
                            </li>
                        </ul>
                    </div>

                    <div class="navbar-item">
                        <ul class="navbar-item__action" v-if="authUser">
                            <li
                                v-on:click="showSearchbar()"
                                ref="searchBoxSource"
                            >
                                <svg
                                    fill="currentColor"
                                    viewBox="0 0 16 16"
                                    height="19"
                                    width="24"
                                    class="x1lliihq x1k90msu x2h7rmj x1qfuztq xcza8v6 xlup9mm x1kky2od"
                                >
                                    <g
                                        fill-rule="evenodd"
                                        transform="translate(-448 -544)"
                                    >
                                        <g fill-rule="nonzero">
                                            <path
                                                d="M10.743 2.257a6 6 0 1 1-8.485 8.486 6 6 0 0 1 8.485-8.486zm-1.06 1.06a4.5 4.5 0 1 0-6.365 6.364 4.5 4.5 0 0 0 6.364-6.363z"
                                                transform="translate(448 544)"
                                            ></path>
                                            <path
                                                d="M10.39 8.75a2.94 2.94 0 0 0-.199.432c-.155.417-.23.849-.172 1.284.055.415.232.794.54 1.103a.75.75 0 0 0 1.112-1.004l-.051-.057a.39.39 0 0 1-.114-.24c-.021-.155.014-.356.09-.563.031-.081.06-.145.08-.182l.012-.022a.75.75 0 1 0-1.299-.752z"
                                                transform="translate(448 544)"
                                            ></path>
                                            <path
                                                d="M9.557 11.659c.038-.018.09-.04.15-.064.207-.077.408-.112.562-.092.08.01.143.034.198.077l.041.036a.75.75 0 0 0 1.06-1.06 1.881 1.881 0 0 0-1.103-.54c-.435-.058-.867.018-1.284.175-.189.07-.336.143-.433.2a.75.75 0 0 0 .624 1.356l.066-.027.12-.061z"
                                                transform="translate(448 544)"
                                            ></path>
                                            <path
                                                d="m13.463 15.142-.04-.044-3.574-4.192c-.599-.703.355-1.656 1.058-1.057l4.191 3.574.044.04c.058.059.122.137.182.24.249.425.249.96-.154 1.41l-.057.057c-.45.403-.986.403-1.411.154a1.182 1.182 0 0 1-.24-.182zm.617-.616.444-.444a.31.31 0 0 0-.063-.052c-.093-.055-.263-.055-.35.024l.208.232.207-.206.006.007-.22.257-.026-.024.033-.034.025.027-.257.22-.007-.007zm-.027-.415c-.078.088-.078.257-.023.35a.31.31 0 0 0 .051.063l.205-.204-.233-.209z"
                                                transform="translate(448 544)"
                                            ></path>
                                        </g>
                                    </g>
                                </svg>
                            </li>
                            <li>
                                <router-link to="/message">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        data-supported-dps="24x24"
                                        fill="currentColor"
                                        class="mercado-match"
                                        width="24"
                                        height="24"
                                        focusable="false"
                                    >
                                        <path
                                            d="M16 4H8a7 7 0 000 14h4v4l8.16-5.39A6.78 6.78 0 0023 11a7 7 0 00-7-7zm-8 8.25A1.25 1.25 0 119.25 11 1.25 1.25 0 018 12.25zm4 0A1.25 1.25 0 1113.25 11 1.25 1.25 0 0112 12.25zm4 0A1.25 1.25 0 1117.25 11 1.25 1.25 0 0116 12.25z"
                                        ></path>
                                    </svg>
                                </router-link>
                            </li>
                            <li class="dropdown" id="connection">
                                <svg
                                    viewBox="0 0 28 28"
                                    class="x1lliihq x1k90msu x2h7rmj x1qfuztq xcza8v6"
                                    fill="currentColor"
                                    height="24"
                                    width="24"
                                    @click="showConnectionBox"
                                >
                                    <path
                                        d="M10.5 4.5c-2.272 0-2.75 1.768-2.75 3.25C7.75 9.542 8.983 11 10.5 11s2.75-1.458 2.75-3.25c0-1.482-.478-3.25-2.75-3.25zm0 8c-2.344 0-4.25-2.131-4.25-4.75C6.25 4.776 7.839 3 10.5 3s4.25 1.776 4.25 4.75c0 2.619-1.906 4.75-4.25 4.75zm9.5-6c-1.41 0-2.125.841-2.125 2.5 0 1.378.953 2.5 2.125 2.5 1.172 0 2.125-1.122 2.125-2.5 0-1.659-.715-2.5-2.125-2.5zm0 6.5c-1.999 0-3.625-1.794-3.625-4 0-2.467 1.389-4 3.625-4 2.236 0 3.625 1.533 3.625 4 0 2.206-1.626 4-3.625 4zm4.622 8a.887.887 0 00.878-.894c0-2.54-2.043-4.606-4.555-4.606h-1.86c-.643 0-1.265.148-1.844.413a6.226 6.226 0 011.76 4.336V21h5.621zm-7.122.562v-1.313a4.755 4.755 0 00-4.749-4.749H8.25A4.755 4.755 0 003.5 20.249v1.313c0 .518.421.938.937.938h12.125c.517 0 .938-.42.938-.938zM20.945 14C24.285 14 27 16.739 27 20.106a2.388 2.388 0 01-2.378 2.394h-5.81a2.44 2.44 0 01-2.25 1.5H4.437A2.44 2.44 0 012 21.562v-1.313A6.256 6.256 0 018.25 14h4.501a6.2 6.2 0 013.218.902A5.932 5.932 0 0119.084 14h1.861z"
                                    ></path>
                                </svg>
                                <div
                                    class="dropdown-menu"
                                    id="box"
                                    aria-labelledby="navbarDropdown"
                                    v-bind:class="{
                                        connectionMenuActive: isConnectionBox,
                                    }"
                                >
                                    <h1>Connections</h1>
                                    <div>
                                        <button
                                            @click="getConnection"
                                            v-bind:class="{
                                                btnActive: isConnection,
                                            }"
                                        >
                                            Connections
                                        </button>
                                        <button
                                            @click="getRequest"
                                            v-bind:class="{
                                                btnActive: isRequest,
                                            }"
                                        >
                                            Requests
                                        </button>
                                    </div>
                                    <ul v-if="isLoading == true">
                                        <li class="skeleton nav-link">
                                            <img />
                                            <p></p>
                                        </li>
                                        <li class="skeleton nav-link">
                                            <img />
                                            <p></p>
                                        </li>
                                        <li class="skeleton nav-link">
                                            <img />
                                            <p></p>
                                        </li>
                                        <li class="skeleton nav-link">
                                            <img />
                                            <p></p>
                                        </li>
                                        <li class="skeleton nav-link">
                                            <img />
                                            <p></p>
                                        </li>
                                    </ul>
                                    <ul
                                        v-else-if="
                                            isLoading == false &&
                                            connectionItem != undefined &&
                                            connectionItem.length > 0
                                        "
                                    >
                                        <li
                                            v-for="(
                                                connection, index
                                            ) in connectionItem"
                                        >
                                            <router-link
                                                class="connection-item"
                                                v-if="
                                                    authUser.id ==
                                                    connection.from_id
                                                "
                                                :to="`/profile/${connection.user2.slug}/overview`"
                                            >
                                                <img
                                                    :src="
                                                        connection.user2.image
                                                    "
                                                />
                                                <div>
                                                    <h4>
                                                        {{
                                                            connection.user2
                                                                .name
                                                        }}
                                                    </h4>
                                                    <p>
                                                        {{
                                                            connection.user2
                                                                .designation
                                                        }}
                                                    </p>
                                                </div>
                                            </router-link>
                                            <router-link
                                                class="connection-item"
                                                v-else-if="
                                                    authUser.id ==
                                                    connection.to_id
                                                "
                                                :to="`/profile/${connection.user1.slug}/overview`"
                                            >
                                                <img
                                                    :src="
                                                        connection.user1.image
                                                    "
                                                />
                                                <div>
                                                    <h4>
                                                        {{
                                                            connection.user1
                                                                .name
                                                        }}
                                                    </h4>
                                                    <p>
                                                        {{
                                                            connection.user1
                                                                .designation
                                                        }}
                                                    </p>
                                                </div>
                                            </router-link>
                                        </li>
                                        <div
                                            class="justify-content-center d-flex"
                                            @click="loadMoreConnection(4)"
                                            v-if="
                                                !loadMoreLoading &&
                                                !noConnectionDataRemaining
                                            "
                                        >
                                            <button>View all</button>
                                        </div>
                                        <div
                                            v-if="
                                                loadMoreLoading &&
                                                !noConnectionDataRemaining
                                            "
                                            class="loader-sm"
                                        >
                                            <i
                                                class="ivu-load-loop ivu-icon ivu-icon-ios-loading"
                                            ></i>
                                        </div>
                                    </ul>
                                    <div v-else>
                                        <h1 class="mt-5 text-center">
                                            No data found!!
                                        </h1>
                                    </div>
                                </div>
                            </li>

                            <li class="dropdown" id="connection">
                                <svg
                                    viewBox="0 0 28 28"
                                    alt=""
                                    class="x1lliihq x1k90msu x2h7rmj x1qfuztq x198g3q0"
                                    fill="currentColor"
                                    height="24"
                                    width="24"
                                    @click="showNotificationBox"
                                >
                                    <path
                                        d="M7.847 23.488C9.207 23.488 11.443 23.363 14.467 22.806 13.944 24.228 12.581 25.247 10.98 25.247 9.649 25.247 8.483 24.542 7.825 23.488L7.847 23.488ZM24.923 15.73C25.17 17.002 24.278 18.127 22.27 19.076 21.17 19.595 18.724 20.583 14.684 21.369 11.568 21.974 9.285 22.113 7.848 22.113 7.421 22.113 7.068 22.101 6.79 22.085 4.574 21.958 3.324 21.248 3.077 19.976 2.702 18.049 3.295 17.305 4.278 16.073L4.537 15.748C5.2 14.907 5.459 14.081 5.035 11.902 4.086 7.022 6.284 3.687 11.064 2.753 15.846 1.83 19.134 4.096 20.083 8.977 20.506 11.156 21.056 11.824 21.986 12.355L21.986 12.356 22.348 12.561C23.72 13.335 24.548 13.802 24.923 15.73Z"
                                    ></path>
                                </svg>
                                <span
                                    class="navbar-item__action__badge"
                                    v-if="this.seenCount > 0"
                                    >{{ this.seenCount }}</span
                                >
                                <div
                                    class="dropdown-menu"
                                    id="box"
                                    aria-labelledby="navbarDropdown"
                                    v-bind:class="{
                                        connectionMenuActive: isNotificationBox,
                                    }"
                                >
                                    <h1>Notifications</h1>
                                    <div>
                                        <button
                                            @click="getNotification"
                                            v-bind:class="{ btnActive: isAll }"
                                        >
                                            All
                                        </button>
                                        <!-- <button
                    @click="getReadNotification"
                    v-bind:class="{ btnActive: isRead }"
                  >
                    Read
                  </button> -->
                                        <button
                                            @click="getUnreadNotification"
                                            v-bind:class="{
                                                btnActive: isUnread,
                                            }"
                                        >
                                            Unread
                                        </button>
                                    </div>

                                    <ul v-if="isLoading == true">
                                        <li class="skeleton nav-link">
                                            <img />
                                            <p></p>
                                        </li>
                                        <li class="skeleton nav-link">
                                            <img />
                                            <p></p>
                                        </li>
                                        <li class="skeleton nav-link">
                                            <img />
                                            <p></p>
                                        </li>
                                        <li class="skeleton nav-link">
                                            <img />
                                            <p></p>
                                        </li>
                                        <li class="skeleton nav-link">
                                            <img />
                                            <p></p>
                                        </li>
                                    </ul>
                                    <ul
                                        v-else-if="
                                            isLoading == false &&
                                            notificationItem != undefined &&
                                            notificationItem.length > 0
                                        "
                                    >
                                        <div class="box">
                                            <li
                                                v-for="(
                                                    notification, index
                                                ) in notificationItem"
                                                @click="markAsRead(index)"
                                            >
                                                <router-link
                                                    class="connection-item"
                                                    v-if="
                                                        notification.data.msg ==
                                                            'accepted your request' ||
                                                        notification.data.msg ==
                                                            'requested to connect you'
                                                    "
                                                    :to="`/profile/${notification.data.user_slug}/overview`"
                                                    v-bind:class="{
                                                        active:
                                                            notification.read_at ==
                                                            null,
                                                    }"
                                                >
                                                    <div>
                                                        <img
                                                            :src="
                                                                notification
                                                                    .data
                                                                    .user_image
                                                            "
                                                        />
                                                        <span
                                                            class="connection-action connection-action__like"
                                                            ><i
                                                                class="fa-solid fa-user-group"
                                                            ></i
                                                        ></span>
                                                    </div>
                                                    <div>
                                                        <router-link
                                                            :to="`/profile/${notification.data.user_slug}/overview`"
                                                            >{{
                                                                notification
                                                                    .data
                                                                    .user_name
                                                            }}</router-link
                                                        >
                                                        <span>{{
                                                            notification.data
                                                                .msg
                                                        }}</span>
                                                    </div>
                                                </router-link>
                                                <router-link
                                                    class="connection-item"
                                                    v-else
                                                    :to="`/description/${notification.data.post_slug}/overview`"
                                                    v-bind:class="{
                                                        active:
                                                            notification.read_at ==
                                                            null,
                                                    }"
                                                >
                                                    <div>
                                                        <img
                                                            :src="
                                                                notification
                                                                    .data
                                                                    .user_image
                                                            "
                                                        />
                                                        <span
                                                            class="connection-action connection-action__like"
                                                            v-if="
                                                                notification
                                                                    .data.msg ==
                                                                'liked your'
                                                            "
                                                            ><i
                                                                class="fa-solid fa-thumbs-up"
                                                            ></i
                                                        ></span>
                                                        <span
                                                            class="connection-action connection-action__upVote"
                                                            v-else-if="
                                                                notification
                                                                    .data.msg ==
                                                                'up voted your'
                                                            "
                                                            ><i
                                                                class="fa-solid fa-caret-up"
                                                            ></i
                                                        ></span>
                                                        <span
                                                            class="connection-action connection-action__downVote"
                                                            v-else-if="
                                                                notification
                                                                    .data.msg ==
                                                                'down voted your'
                                                            "
                                                            ><i
                                                                class="fa-solid fa-caret-down"
                                                            ></i
                                                        ></span>
                                                        <span
                                                            class="connection-action connection-action__like"
                                                            v-else-if="
                                                                notification
                                                                    .data.msg ==
                                                                'commented your'
                                                            "
                                                            ><i
                                                                class="fa-solid fa-comment"
                                                            ></i
                                                        ></span>
                                                    </div>
                                                    <p>
                                                        <router-link
                                                            :to="`/profile/${notification.data.user_slug}/overview`"
                                                            >{{
                                                                notification
                                                                    .data
                                                                    .user_name
                                                            }}</router-link
                                                        >
                                                        {{
                                                            notification.data
                                                                .msg +
                                                            " " +
                                                            notification.data
                                                                .post_type
                                                        }}
                                                    </p>
                                                </router-link>
                                            </li>
                                        </div>
                                        <div
                                            class="justify-content-center d-flex"
                                            @click="loadAllNotification(4)"
                                            v-if="
                                                !loadMoreLoading &&
                                                !noNotificationDataRemaining
                                            "
                                        >
                                            <button>View all</button>
                                        </div>
                                        <div
                                            v-if="
                                                loadMoreLoading &&
                                                !noNotificationDataRemaining
                                            "
                                            class="loader-sm"
                                        >
                                            <i
                                                class="ivu-load-loop ivu-icon ivu-icon-ios-loading"
                                            ></i>
                                        </div>
                                    </ul>
                                    <div v-else>
                                        <h1 class="mt-5 text-center">
                                            No data found!!
                                        </h1>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown profile">
                                <router-link
                                    :to="`/profile/${authUser.slug}/overview`"
                                >
                                    <img :src="authUser.image" alt="img"
                                /></router-link>
                                <i
                                    class="lni lni-chevron-down"
                                    style="color: #fff"
                                ></i>
                                <ul
                                    class="dropdown-menu"
                                    aria-labelledby="navbarDropdown"
                                >
                                    <li>
                                        <router-link
                                            class="dropdown-item"
                                            :to="`/profile/${authUser.slug}/overview`"
                                            >Your Profile</router-link
                                        >
                                    </li>
                                    <li>
                                        <a @click="logout" class="dropdown-item"
                                            >Log Out</a
                                        >
                                    </li>
                                </ul>
                            </li>

                            <li v-on:click="showSidebar()" class="d-lg-none">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="25"
                                    height="25"
                                    fill="currentColor"
                                    class="bi bi-list"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"
                                    />
                                </svg>
                            </li>
                        </ul>
                        <ul class="navbar-item__action" v-else>
                            <li class="profile">
                                <router-link class="nav-link" to="/login"
                                    >Login</router-link
                                >
                            </li>
                            <li class="profile">
                                <router-link
                                    class="nav-link profile"
                                    to="/register"
                                    >Register</router-link
                                >
                            </li>
                            <li v-on:click="showSidebar()" class="d-lg-none">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="25"
                                    height="25"
                                    fill="currentColor"
                                    class="bi bi-list"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"
                                    />
                                </svg>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
const { io } = require("socket.io-client");

export default {
    data() {
        return {
            isLoading: false,
            isSidebar: false,
            isSearchbar: false,
            isConnectionBox: false,
            isConnection: true,
            isAllConnection: false,
            isRequest: false,
            isNotification: false,
            isNotificationBox: false,
            isFilter: false,
            isAll: true,
            isRead: false,
            isUnread: false,
            sendRequest: false,
            receivedRequest: false,
            approvedRequest: false,
            sending: false,
            ignored: false,
            loadMoreLoading: false,
            noConnectionDataRemaining: false,
            noNotificationDataRemaining: false,
            keyword: "",
            Users: [],
            user_id: -1,
            user_slug: "",
            limit: 3,
            socket: null,
        };
    },
    watch: {
        keyword(after, before) {
            this.getResults();
        },
        "$route.params"(oldValue, newValue) {
            if (oldValue != newValue) {
                this.hideNotification();
                this.hideSidebar();
                this.hideSearchbar();
                this.hideConnection();

                this.hideConnectionBox();
                this.hideNotificationBox();
                // if (this.authUser) {
                //   this.callCount();
                // }
            }
        },
    },

    computed: {
        ...mapGetters({
            seenCount: "getSeenCount",
            notificationItem: "getNotificationItem",
            connectionItem: "getAuthUserConnection",
        }),
    },
    methods: {
        showSidebar() {
            this.isSidebar = true;
            this.hideConnectionBox();
        },
        hideSidebar() {
            this.isSidebar = false;
        },

        showConnectionBox() {
            console.log("inside showConnectionBox");
            this.hideNotificationBox();
            if (this.isConnectionBox == true) {
                this.isConnectionBox = false;
            } else {
                this.isConnectionBox = true;
                this.getConnection();
            }
        },
        hideConnectionBox() {
            this.isConnectionBox = false;
            // this.isAllConnection = false;
            this.isRequest = false;
        },
        hideConnection() {
            this.isAllConnection = false;
            this.isRequest = false;
        },
        showSearchbar() {
            this.hideConnectionBox();
            this.isSearchbar = true;
            this.$nextTick(() => {
                if (this.$refs["search" + this.keyword]) {
                    this.$refs["search" + this.keyword].focus();
                }
            });
        },
        cancelSearchBar() {
            this.isSearchbar = false;
            this.keyword = "";
        },
        clearSearchBar() {
            this.keyword = "";
        },
        getSearchedUser(user) {
            //     const res = await this.callApi(
            //     "get",
            //     `/api/get_profile_info/${this.user_id}`
            // );
            this.user_slug = user.slug;
            this.hideSearchbar(user);
            this.$router.push(`/profile/${this.user_slug}/overview`);
            // this.keyword = "";
        },
        async getResults() {
            const res = await this.callApi(
                "get",
                `/api/search?keyword=${this.keyword}&limit=${this.limit}`
            );
            if (res.status == 200) {
                this.Users = res.data;
            } else {
                this.swr();
            }
        },
        async loadMoreUser(more) {
            this.limit = this.limit + more;
            this.loadMoreLoading = true;
            const res = await this.callApi(
                "get",
                `/api/search?keyword=${this.keyword}&limit=${this.limit}`
            );
            if (res.status == 200) {
                this.Users = res.data;

                // for (let i in res.data.data) {
                //   console.log("pushing data");
                //   let d = res.data.data[i];
                //   if (i >= prevLength) {
                //     this.$store.commit("pushConnection", d);
                //   }
                // }
            }
            this.loadMoreLoading = false;
        },
        hideSearchbar(e) {
            if (this.isSearchbar) {
                let target = e.target;
                var container = this.$refs.searchBox;
                var source = this.$refs.searchBoxSource;

                if (!source.contains(target) && !container.contains(target)) {
                    this.isSearchbar = false;
                    this.keyword = "";
                }
            }
        },
        async showNotificationBox() {
            console.log("inside showNotificationBox");
            this.hideConnectionBox();

            if (this.isNotificationBox == true) {
                this.hideNotificationBox();
            } else {
                this.isNotificationBox = true;
                this.getNotification();
                if (this.seenCount > 0) {
                    const res = await this.callApi("post", "/api/mark_as_seen");
                    if (res.status == 200) {
                        this.$store.dispatch("updateSeenCount", 0);
                    }
                }
            }
        },
        hideNotificationBox() {
            this.isNotificationBox = false;
            this.isUnread = false;
        },
        async showNotification() {
            this.hideConnectionBox();
            this.hideNotificationBox();
            this.isNotification = true;
            this.getNotification();
            if (this.seenCount > 0) {
                const res = await this.callApi("post", "/api/mark_as_seen");
                if (res.status == 200) {
                    this.$store.dispatch("updateSeenCount", 0);
                }
            }
        },
        hideNotification() {
            this.isNotification = false;
        },

        async markAsRead(index) {
            this.hideNotification();
            this.isNotificationBox = false;

            if (this.notificationItem[index].read_at == null) {
                let id = this.notificationItem[index].id;
                const res = await this.callApi(
                    "get",
                    `/api/mark_as_read/${id}`
                );
            }
        },
        async getDepartments() {
            const res = await this.callApi("get", "/api/get_departments");
            if (res.status == 200) {
                this.$store.commit("updateDepartment", res.data.data);
            } else {
                this.swr();
            }
        },

        async getConnection() {
            this.isConnection = true;
            this.isRequest = false;
            this.isLoading = true;
            const connection = await this.callApi(
                "get",
                `/api/get_auth_user_connection?limit=${this.limit}`
            );

            if (connection.status == 200) {
                this.$store.commit(
                    "updateAuthUserConnection",
                    connection.data.data
                );
                // if (connection.data.data.length < 6)
                //   this.noConnectionDataRemaining = true;
            }
            this.isLoading = false;
        },
        async loadMoreConnection(more) {
            console.log(
                "Load more is calling! length",
                this.connectionItem.length
            );
            this.hideConnectionBox();
            this.isAllConnection = true;
            if (this.noConnectionDataRemaining) return;

            this.limit = this.limit + more;
            this.loadMoreLoading = true;
            const res = await this.callApi(
                "get",
                `/api/get_auth_user_connection?limit=${this.limit}`
            );
            if (res.status == 200) {
                let prevLength = this.connectionItem.length;
                if (this.connectionItem.length == res.data.data.length) {
                    this.noConnectionDataRemaining = true;
                }
                for (let i in res.data.data) {
                    console.log("pushing data");
                    let d = res.data.data[i];
                    if (i >= prevLength) {
                        this.$store.commit("pushAuthUserConnection", d);
                    }
                }
            }
            this.loadMoreLoading = false;
            console.log(
                "Load more is finished! length",
                this.connectionItem.length
            );
        },
        async getRequest() {
            this.isConnection = false;
            this.isRequest = true;
            this.isLoading = true;
            const connection = await this.callApi(
                "get",
                `/api/get_connection_request?limit=${this.limit}`
            );

            if (connection.status == 200) {
                this.$store.commit(
                    "updateAuthUserConnection",
                    connection.data.data
                );
            }
            this.isLoading = false;
        },
        async getNotification() {
            this.isAll = true;
            this.isRead = false;
            this.isUnread = false;
            this.isRequest = false;
            this.isLoading = true;
            const notification = await this.callApi(
                "get",
                `/api/get_notification?limit=${this.limit}`
            );

            if (notification.status == 200) {
                console.log(notification.data.data);
                this.$store.dispatch(
                    "updateSeenCount",
                    notification.data.count
                );
                this.$store.dispatch(
                    "updateNotification",
                    notification.data.data
                );
            }
            this.isLoading = false;
        },
        async loadAllNotification(more) {
            console.log(
                "Load more is calling! length",
                this.notificationItem.length
            );
            this.hideNotificationBox();
            this.isNotification = true;

            if (this.noNotificationDataRemaining) return;

            this.limit = this.limit + more;
            this.loadMoreLoading = true;
            const res = await this.callApi(
                "get",
                `/api/get_notification?limit=${this.limit}`
            );
            if (res.status == 200) {
                let prevLength = this.notificationItem.length;
                if (this.notificationItem.length == res.data.data.length) {
                    this.noNotificationDataRemaining = true;
                }
                for (let i in res.data.data) {
                    console.log("pushing data");
                    let d = res.data.data[i];
                    if (i >= prevLength) {
                        this.$store.commit("pushNotification", d);
                    }
                }
            }
            this.loadMoreLoading = false;
            console.log(
                "Load more is finished! length",
                this.notificationItem.length
            );
        },
        async callCount() {
            const notification = await this.callApi(
                "get",
                `/api/get_notification_count?count=${this.seenCount}`
            );

            if (notification.status == 201) {
                this.$store.dispatch(
                    "updateSeenCount",
                    notification.data.count
                );
            }
        },
        async getReadNotification() {
            this.isAll = false;
            this.isRead = true;
            this.isUnread = false;
            this.isRequest = false;
            this.isLoading = true;

            const notification = await this.callApi(
                "get",
                "/api/get_read_notification"
            );

            if (notification.status == 200) {
                console.log(notification.data.data);
                this.$store.dispatch(
                    "updateNotification",
                    notification.data.data
                );
            }
            this.isLoading = false;
        },
        async getUnreadNotification() {
            this.isAll = false;
            this.isRead = false;
            this.isUnread = true;
            this.isRequest = false;
            this.isLoading = true;
            const notification = await this.callApi(
                "get",
                "/api/get_unread_notification"
            );
            if (notification.status == 200) {
                console.log(notification.data.data);
                this.$store.dispatch(
                    "updateNotification",
                    notification.data.data
                );
            }
            this.isLoading = false;
        },

        // async getRequestNotification() {
        //   this.isAll = false;
        //   this.isRead = false;
        //   this.isUnread = false;
        //   this.isRequest = true;
        //   this.isLoading = true;
        //   const notification = await this.callApi(
        //     "get",
        //     "/api/get_request_notification"
        //   );
        //   if (notification.status == 200) {
        //     console.log(notification.data.data);
        //     this.$store.dispatch("updateNotification", notification.data.data);
        //   }
        //   this.isLoading = false;
        // },
        async logout() {
            try {
                const res = await this.callApi("get", "/api/logout");
                if (res.status == 200) {
                    window.location = "/";
                    this.$store.commit("setAuthInfo", false);
                    this.setCookie("token", null);
                    this.s("You Are Logged Out");
                    // this.$router.push("/");
                } else {
                    this.swr();
                }
            } catch (error) {
                console.log(error);
            }
        },
    },

    mounted() {
        document.addEventListener("click", this.hideSearchbar);
        // if (this.authUser) {
        //   const timer = setInterval(() => {
        //     this.callCount();
        //   }, 10000);
        // }
        this.socket = io("http://localhost:5000", {
            methods: ["GET", "POST"],
            transports: ["websocket"],
            credentials: true,
        });

        this.socket.on("get_notification", (data) => {
            console.log(data);
            if (data.id == this.authUser.id) this.callCount();
        });
    },
    beforeDestroy() {
        document.removeEventListener("click", this.hideSearchbar);
    },
    // async asyncData({ app, store, redirect, params }) {
    //   try {
    //     let [res] = await Promise.all([app.$axios.get(`/api/get_departments`)]);
    //     return {
    //       departments: res.data.data,
    //     };
    //   } catch (error) {
    //     console.log("error from asyncData server");
    //     console.log(error);
    //     //   return redirect("/");
    //   }
    // },
    async created() {
        // console.log(this.seenCount);
        // console.log(this.connectionItem);
        if (this.authUser) {
            this.callCount();
            // this.callCount();
            // this.getConnection();
            // console.log(this.connectionItem);
        }
        // this.getDepartments();
    },
};
</script>
